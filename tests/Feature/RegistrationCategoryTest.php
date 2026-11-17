<?php

namespace Tests\Feature;

use App\Mail\RegistrationOtp;
use App\Models\Batch;
use App\Models\StudentRegistry;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_nim_is_required_and_identity_cannot_be_changed_by_browser(): void
    {
        config(['app.registration_open' => true, 'app.registration_mail_verified' => true]);
        Mail::fake();
        $batch = Batch::create(['name' => 'Test', 'active' => true, 'expires_at' => now()->addDays(7)]);
        $batch->coupons()->create(['code' => 'CATEGORY-1']);
        $student = StudentRegistry::create(['nim' => '00123456', 'name' => 'Peserta Uji', 'education_level' => 'S1', 'study_program' => 'Akuntansi', 'registration_type' => 'active_student']);
        $this->get('/daftar')->assertSee('Mahasiswa Aktif')->assertSee('Alumni');
        $this->post('/daftar/otp', ['email' => 'category@example.com', 'phone' => '081210820130'])->assertSessionHasErrors('nim');
        $this->post('/daftar/lookup', ['type' => 'alumni', 'nim' => $student->nim])->assertRedirect();
        $this->get('/daftar')->assertSee('Lengkapi data alumni');
        $this->post('/daftar/lookup', ['type' => 'active_student', 'nim' => $student->nim])->assertRedirect();
        $this->get('/daftar')->assertSee('Peserta Uji')->assertSee('Akuntansi');
        $this->post('/daftar/otp', ['email' => 'category@example.com', 'phone' => '081210820130', 'registration_type' => 'alumni', 'student_registry_id' => 999])->assertRedirect();
        $otp = null;
        Mail::assertSent(RegistrationOtp::class, function ($mail) use (&$otp) { $otp = $mail->otp; return true; });
        $this->post('/daftar', ['otp' => $otp])->assertOk();
        $ticket = Ticket::firstOrFail();
        $this->assertSame('active_student', $ticket->registration_type);
        $this->assertEquals($student->id, $ticket->student_registry_id);
    }

    public function test_registration_ui_ux_flow_and_reset(): void
    {
        config(['app.registration_open' => true, 'app.registration_mail_verified' => true]);
        $batch = Batch::create(['name' => 'Test Batch', 'active' => true, 'expires_at' => now()->addDays(7)]);
        $batch->coupons()->create(['code' => 'TEST-123']);
        $student = StudentRegistry::create([
            'nim' => '2150201001',
            'name' => 'Budi Santoso',
            'education_level' => 'S1-FEB',
            'study_program' => 'Manajemen Bisnis',
            'registration_type' => 'active_student',
        ]);

        // Default loads Mahasiswa Aktif lookup
        $res = $this->get('/daftar');
        $res->assertOk();
        $res->assertSee('Mahasiswa Aktif');
        $res->assertSee('Alumni');
        $res->assertSee('Cek NIM');
        $res->assertSee('panel-active_student');

        // Check alumni when no alumni data exists
        $resAlumni = $this->get('/daftar?type=alumni');
        $resAlumni->assertOk();
        $resAlumni->assertSee('Pendaftaran alumni belum tersedia');

        // Lookup valid student
        $this->post('/daftar/lookup', ['type' => 'active_student', 'nim' => '2150201001'])->assertRedirect('/daftar');

        // View displays verified card with name, study program, and Ganti NIM link
        $verifiedRes = $this->get('/daftar');
        $verifiedRes->assertOk();
        $verifiedRes->assertSee('Budi Santoso');
        $verifiedRes->assertSee('Manajemen Bisnis');
        $verifiedRes->assertSee('Ganti NIM');
        $verifiedRes->assertSee('Kirim OTP');

        // Reset clears verified student and returns to category lookup
        $resetRes = $this->get('/daftar?reset=1');
        $resetRes->assertRedirect('/daftar');
        $this->get('/daftar')->assertDontSee('Budi Santoso')->assertSee('Cek NIM');
    }
}
