<?php
namespace App\Http\Controllers;
use App\Models\Ticket;
use App\Services\RegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
class RegistrationController extends Controller {
    public function form() { return view('registration.form', ['available' => RegistrationService::available()]); }
    public function otp(Request $request, RegistrationService $service) {
        if (!config('app.registration_open') || !config('app.registration_mail_verified')) abort(404);
        $data=$request->validate(['email'=>'required|email','phone'=>'required|string|max:30']);
        $key='otp:'.$request->ip().':'.sha1(strtolower($data['email']));
        if (RateLimiter::tooManyAttempts($key, 5)) throw ValidationException::withMessages(['email'=>'Terlalu banyak permintaan. Coba lagi nanti.']);
        RateLimiter::hit($key, 600);
        $pending=$service->requestOtp($data['email'],$data['phone']);
        $request->session()->put('registration_pending',$pending->id);
        return back()->with('success','OTP telah dikirim ke email Anda.');
    }
    public function resendOtp(Request $request, RegistrationService $service) {
        if (!config('app.registration_open') || !config('app.registration_mail_verified')) abort(404);
        $pending=\App\Models\PendingRegistration::findOrFail($request->session()->get('registration_pending'));
        $service->requestOtp($pending->email,$pending->phone);
        return back()->with('success','OTP baru telah dikirim ke email Anda.');
    }
    public function complete(Request $request, RegistrationService $service) {
        if (!config('app.registration_open') || !config('app.registration_mail_verified')) abort(404);
        $data=$request->validate(['otp'=>'required|digits:6']);
        $id=$request->session()->get('registration_pending');
        abort_unless($id, 404);
        $ticket=$service->complete($id,$data['otp']);
        try { $service->sendTicket($ticket); } catch (\Throwable $e) { report($e); }
        $request->session()->forget('registration_pending');
        return view('registration.success', compact('ticket'));
    }
    public function resend(Ticket $ticket, RegistrationService $service) { $service->sendTicket($ticket); return back()->with('success','Tiket dikirim ulang.'); }
}
