<?php
namespace App\Mail;
use Illuminate\Mail\Mailable;
class RegistrationOtp extends Mailable {
    public function __construct(public string $otp) {}
    public function build(): self { return $this->subject('Kode verifikasi Dies Natalis FEB UB')->view('mail.otp'); }
}
