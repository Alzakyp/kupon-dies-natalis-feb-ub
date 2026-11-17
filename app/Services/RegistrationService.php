<?php

namespace App\Services;

use App\Mail\RegistrationOtp;
use App\Mail\TicketIssued;
use App\Models\Coupon;
use App\Models\PendingRegistration;
use App\Models\Ticket;
use App\Models\StudentRegistry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegistrationService
{
    public static function email(string $email): string { return Str::lower(trim($email)); }

    public static function phone(string $phone): string
    {
        $number = preg_replace('/[\s\-()]/', '', $phone);
        if (str_starts_with($number, '+62')) $number = substr($number, 1);
        elseif (str_starts_with($number, '0')) $number = '62'.substr($number, 1);
        if (!preg_match('/^628[0-9]{8,12}$/', $number)) throw ValidationException::withMessages(['phone' => 'Nomor HP Indonesia tidak valid.']);
        return $number;
    }

    public static function available(): bool { return true; }

    public function requestOtp(string $email, string $phone, ?int $registryId = null, ?string $registrationType = null): PendingRegistration
    {
        $email = self::email($email);
        $phone = self::phone($phone);
        if (!$registryId || !$registrationType) throw ValidationException::withMessages(['nim' => 'Validasi NIM terlebih dahulu.']);
        if (!StudentRegistry::whereKey($registryId)->where('registration_type', $registrationType)->exists())
            throw ValidationException::withMessages(['nim' => 'Data NIM tidak valid.']);
        if (Ticket::where('student_registry_id', $registryId)->exists())
            throw ValidationException::withMessages(['nim' => 'NIM sudah terdaftar.']);
        if (Ticket::where('email', $email)->orWhere('phone', $phone)->exists())
            throw ValidationException::withMessages(['email' => 'Pendaftaran tidak dapat diproses. Hubungi petugas.']);

        $existing = PendingRegistration::where('email', $email)->orWhere('phone', $phone)->first();
        if ($existing && ($existing->email !== $email || $existing->phone !== $phone))
            throw ValidationException::withMessages(['email' => 'Pendaftaran tidak dapat diproses. Hubungi petugas.']);
        if ($existing && $existing->otp_sent_at->gt(now()->subSeconds(60)))
            throw ValidationException::withMessages(['email' => 'Tunggu 60 detik sebelum mengirim ulang OTP.']);

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $pending = PendingRegistration::updateOrCreate(['email' => $email], [
            'phone' => $phone, 'student_registry_id' => $registryId, 'registration_type' => $registrationType, 'otp_hash' => Hash::make($otp), 'otp_expires_at' => now()->addMinutes(10),
            'otp_attempts' => 0, 'otp_sent_at' => now(),
        ]);
        Mail::to($email)->send(new RegistrationOtp($otp));
        return $pending;
    }

    public function complete(int $pendingId, string $otp): Ticket
    {
        $ticket = DB::transaction(function () use ($pendingId, $otp) {
            $pending = PendingRegistration::lockForUpdate()->findOrFail($pendingId);
            $registry = StudentRegistry::lockForUpdate()->find($pending->student_registry_id);
            if (!$registry || $registry->registration_type !== $pending->registration_type || Ticket::where('student_registry_id', $registry->id)->exists())
                throw ValidationException::withMessages(['nim' => 'NIM tidak valid atau sudah terdaftar.']);
            if ($pending->otp_expires_at->isPast() || $pending->otp_attempts >= 5)
                throw ValidationException::withMessages(['otp' => 'OTP kedaluwarsa atau terkunci.']);
            if (!Hash::check($otp, $pending->otp_hash)) {
                $pending->increment('otp_attempts');
                return null;
            }
            if (Ticket::where('email', $pending->email)->orWhere('phone', $pending->phone)->exists())
                throw ValidationException::withMessages(['otp' => 'Pendaftaran sudah selesai.']);
            $ticket = Ticket::create([
                'number' => 'FEB65-'.strtoupper(Str::random(10)),
                'barcode' => Str::random(48), 'email' => $pending->email,
                'phone' => $pending->phone, 'student_registry_id' => $pending->student_registry_id, 'registration_type' => $pending->registration_type,
            ]);
            $pending->delete();
            return $ticket;
        }, 3);
        if (!$ticket) throw ValidationException::withMessages(['otp' => 'OTP tidak valid.']);
        return $ticket;
    }

    public function sendTicket(Ticket $ticket): void
    {
        Mail::to($ticket->email)->send(new TicketIssued($ticket));
        $ticket->forceFill(['emailed_at' => now()])->save();
    }
}
