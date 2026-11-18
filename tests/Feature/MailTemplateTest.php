<?php

namespace Tests\Feature;

use App\Mail\RegistrationOtp;
use App\Mail\TicketIssued;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Ticket;
use Tests\TestCase;

class MailTemplateTest extends TestCase
{
    use RefreshDatabase;
    public function test_otp_and_ticket_keep_content_with_branded_email_layout(): void
    {
        $otp = (new RegistrationOtp('123456'))->render();
        $this->assertStringContainsString('123456', $otp);
        $this->assertStringContainsString('10 menit', $otp);
        $this->assertStringContainsString('Lustrum XIII', $otp);
        $this->assertStringContainsString('max-width:600px', $otp);

        $ticket = new Ticket(['number' => 'FEB65-TEST', 'email' => 'test@example.com', 'barcode' => str_repeat('a', 48)]);
        $html = (new TicketIssued($ticket))->render();
        $this->assertStringContainsString('FEB65-TEST', $html);
        $this->assertStringContainsString('Lapangan Rektorat UB', $html);
        $this->assertStringContainsString('05.30 WIB', $html);
        $this->assertStringContainsString('30 November–4 Desember 2026', $html);
        $this->assertStringContainsString('Ruang Tata Usaha', $html);
        $this->assertStringContainsString('Security Command Center', $html);
        $this->assertStringContainsString('Ruang Kemahasiswaan', $html);
        $this->assertStringContainsString('Lustrum XIII', $html);
        $this->assertStringContainsString(str_repeat('a', 48), $html);
    }
}
