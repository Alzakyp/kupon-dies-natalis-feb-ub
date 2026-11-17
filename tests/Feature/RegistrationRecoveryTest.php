<?php
namespace Tests\Feature;
use App\Models\Batch;
use App\Mail\RegistrationOtp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
class RegistrationRecoveryTest extends TestCase {
 use RefreshDatabase;
 public function test_otp_can_be_resent_from_existing_session(): void {
  config(['app.registration_open'=>true,'app.registration_mail_verified'=>true]); Mail::fake();
  $b=Batch::create(['name'=>'Event','active'=>true,'expires_at'=>now()->addDays(7)]);
  $b->coupons()->create(['code'=>'FEB65-RECOVERY']);
  \App\Models\StudentRegistry::create(['nim'=>'000123','name'=>'Test','education_level'=>'S1','study_program'=>'Akuntansi','registration_type'=>'active_student']);
  $this->post('/daftar/lookup',['type'=>'active_student','nim'=>'000123'])->assertRedirect();
  $this->post('/daftar/otp',['email'=>'recovery@example.com','phone'=>'081234567891'])->assertRedirect();
  $this->post('/daftar/otp',['email'=>'recovery@example.com','phone'=>'081234567891'])->assertRedirect()->assertSessionHas('success','OTP sudah dikirim. Masukkan kode dari email atau tunggu countdown untuk mengirim ulang.');
  Mail::assertSent(RegistrationOtp::class, 1);
  $this->travel(61)->seconds();
  $this->post('/daftar/otp/resend')->assertRedirect();
  Mail::assertSent(RegistrationOtp::class,2);
 }
}
