<?php

namespace App\Http\Controllers;

use App\Models\PendingRegistration;
use App\Models\StudentRegistry;
use App\Models\Ticket;
use App\Services\RegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    private function open(): void
    {
        if (!config('app.registration_open') || !config('app.registration_mail_verified')) abort(404);
    }

    public function form(Request $request)
    {
        if ($request->query('reset')) {
            $request->session()->forget(['student_registry_id', 'registration_type', 'registration_pending']);
            return redirect(url('/daftar'));
        }

        $registry = $request->session()->get('student_registry_id');
        return view('registration.form', [
            'available' => RegistrationService::available(),
            'student' => $registry ? StudentRegistry::find($registry) : null,
            'hasAlumniData' => StudentRegistry::where('registration_type', 'alumni')->exists(),
        ]);
    }

    public function lookup(Request $request)
    {
        $this->open();
        $data = $request->validate([
            'type' => ['required', Rule::in(['active_student', 'alumni'])],
            'nim' => 'required|string|max:30',
        ]);
        $nim = StudentRegistry::normalizeNim($data['nim']);
        $key = 'nim:'.$request->ip().':'.sha1($data['type'].'|'.$nim);
        if (RateLimiter::tooManyAttempts($key, 10)) throw ValidationException::withMessages(['nim' => 'Terlalu banyak percobaan. Coba lagi nanti.']);
        RateLimiter::hit($key, 600);
        $student = StudentRegistry::where('registration_type', $data['type'])->where('nim', $nim)->first();
        if (!$student) throw ValidationException::withMessages(['nim' => 'NIM tidak ditemukan untuk kategori pendaftaran ini.']);
        $request->session()->put(['student_registry_id' => $student->id, 'registration_type' => $student->registration_type]);
        return redirect(url('/daftar'))->with('success', 'Data ditemukan. Silakan lanjutkan pendaftaran.');
    }

    public function otp(Request $request, RegistrationService $service)
    {
        $this->open();
        $registryId = $request->session()->get('student_registry_id');
        $type = $request->session()->get('registration_type');
        if (!$registryId || !$type) throw ValidationException::withMessages(['nim' => 'Validasi NIM terlebih dahulu.']);
        $data = $request->validate(['email' => 'required|email', 'phone' => 'required|string|max:30']);
        $key = 'otp:'.$request->ip().':'.sha1(strtolower($data['email']));
        if (RateLimiter::tooManyAttempts($key, 5)) throw ValidationException::withMessages(['email' => 'Terlalu banyak permintaan. Coba lagi nanti.']);
        RateLimiter::hit($key, 600);
        $pending = $service->requestOtp($data['email'], $data['phone'], $registryId, $type);
        $request->session()->put('registration_pending', $pending->id);
        return redirect(url('/daftar'))->with('success', 'OTP telah dikirim ke email Anda.');
    }

    public function resendOtp(Request $request, RegistrationService $service)
    {
        $this->open();
        $pending = PendingRegistration::findOrFail($request->session()->get('registration_pending'));
        $service->requestOtp($pending->email, $pending->phone, $pending->student_registry_id, $pending->registration_type);
        return back()->with('success', 'OTP baru telah dikirim ke email Anda.');
    }

    public function complete(Request $request, RegistrationService $service)
    {
        $this->open();
        $data = $request->validate(['otp' => 'required|digits:6']);
        $id = $request->session()->get('registration_pending');
        abort_unless($id, 404);
        $ticket = $service->complete($id, $data['otp']);
        try { $service->sendTicket($ticket); } catch (\Throwable $e) { report($e); }
        $request->session()->forget(['registration_pending', 'student_registry_id', 'registration_type']);
        return view('registration.success', compact('ticket'));
    }

    public function resend(Ticket $ticket, RegistrationService $service)
    {
        $service->sendTicket($ticket);
        return back()->with('success', 'Tiket dikirim ulang.');
    }
}
