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
            $type = $request->query('type');
            $request->session()->forget(['student_registry_id', 'registration_type', 'registration_pending', 'alumni_nim']);
            return redirect($type ? url('/daftar?type='.$type) : url('/daftar'));
        }

        $registry = $request->session()->get('student_registry_id');
        return view('registration.form', [
            'available' => RegistrationService::available(),
            'student' => $registry ? StudentRegistry::find($registry) : null,
            'manualAlumni' => session('registration_type') === 'alumni' && !$registry ? ['nim' => session('alumni_nim')] : null,
            'studyPrograms' => StudentRegistry::whereNotNull('study_program')->distinct()->orderBy('study_program')->pluck('study_program'),
            'pending' => ($pendingId = $request->session()->get('registration_pending')) ? PendingRegistration::find($pendingId) : null,
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
        if (!$student && $data['type'] === 'alumni') {
            $request->session()->put(['student_registry_id' => null, 'registration_type' => 'alumni', 'alumni_nim' => $nim]);
            return redirect(url('/daftar'))->with('success', 'NIM alumni belum ditemukan. Bagi Alumni angkatan 2003 ke bawah silahkan untuk mengisi data pendaftaran secara manual.');
        }
        if (!$student) throw ValidationException::withMessages(['nim' => 'NIM tidak ditemukan untuk kategori pendaftaran ini.']);
        $request->session()->put(['student_registry_id' => $student->id, 'registration_type' => $student->registration_type]);
        return redirect(url('/daftar'))->with('success', 'Data ditemukan. Silakan lanjutkan pendaftaran.');
    }

    public function otp(Request $request, RegistrationService $service)
    {
        $this->open();
        $registryId = $request->session()->get('student_registry_id');
        $type = $request->session()->get('registration_type');
        if (!$registryId && $type !== 'alumni') throw ValidationException::withMessages(['nim' => 'Validasi NIM terlebih dahulu.']);
        $rules = ['email' => 'required|email', 'phone' => 'required|string|max:30'];
        if (!$registryId && $type === 'alumni') $rules += [
            'name' => 'required|string|max:150',
            'education_level' => ['required', Rule::in(['Diploma', 'Sarjana S1', 'Magister S2', 'Doktor S3', 'Profesi'])],
            'study_program' => ['required', Rule::exists('student_registries', 'study_program')],
        ];
        $data = $request->validate($rules);
        $key = 'otp:'.$request->ip().':'.sha1(strtolower($data['email']));
        if (RateLimiter::tooManyAttempts($key, 5)) throw ValidationException::withMessages(['email' => 'Terlalu banyak permintaan. Coba lagi nanti.']);
        RateLimiter::hit($key, 600);
        $pending = PendingRegistration::where('email', RegistrationService::email($data['email']))
            ->where('phone', RegistrationService::phone($data['phone']))
            ->where('student_registry_id', $registryId)->where('registration_type', $type)
            ->where('otp_sent_at', '>', now()->subSeconds(60))->first();
        if ($pending) {
            $request->session()->put('registration_pending', $pending->id);
            return redirect(url('/daftar'))->with('success', 'OTP sudah dikirim. Masukkan kode dari email atau tunggu countdown untuk mengirim ulang.');
        }
        $identity = !$registryId ? ['nim' => session('alumni_nim'), 'name' => $data['name'], 'education_level' => $data['education_level'], 'study_program' => $data['study_program']] : null;
        $pending = $service->requestOtp($data['email'], $data['phone'], $registryId, $type, $identity);
        $request->session()->put('registration_pending', $pending->id);
        return redirect(url('/daftar'))->with('success', 'OTP telah dikirim ke email Anda.');
    }

    public function resendOtp(Request $request, RegistrationService $service)
    {
        $this->open();
        $pendingId = $request->session()->get('registration_pending');
        if (!$pendingId) return redirect(url('/daftar'))->withErrors(['otp' => 'Sesi OTP berakhir. Silakan mulai kembali.']);
        $pending = PendingRegistration::find($pendingId);
        if (!$pending) {
            $request->session()->forget('registration_pending');
            return redirect(url('/daftar'))->withErrors(['otp' => 'Sesi OTP berakhir. Silakan mulai kembali.']);
        }
        $pending = $service->requestOtp($pending->email, $pending->phone, $pending->student_registry_id, $pending->registration_type, $pending->manual_identity);
        $request->session()->put('registration_pending', $pending->id);
        return redirect(url('/daftar'))->with('success', 'OTP baru telah dikirim ke email Anda.');
    }

    public function complete(Request $request, RegistrationService $service)
    {
        $this->open();
        $data = $request->validate(['otp' => 'required|digits:6']);
        $id = $request->session()->get('registration_pending');
        abort_unless($id, 404);
        $ticket = $service->complete($id, $data['otp']);
        try { $service->sendTicket($ticket); } catch (\Throwable $e) { report($e); }
        $request->session()->forget(['registration_pending', 'student_registry_id', 'registration_type', 'alumni_nim']);
        return view('registration.success', compact('ticket'));
    }

    public function resend(Ticket $ticket, RegistrationService $service)
    {
        $service->sendTicket($ticket);
        return back()->with('success', 'Tiket dikirim ulang.');
    }
}
