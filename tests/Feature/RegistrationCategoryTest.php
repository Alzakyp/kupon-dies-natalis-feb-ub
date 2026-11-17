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
        $this->post('/daftar/lookup', ['type' => 'alumni', 'nim' => $student->nim])->assertSessionHasErrors('nim');
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
}
