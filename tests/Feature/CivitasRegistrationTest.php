<?php
namespace Tests\Feature;
use App\Mail\RegistrationOtp;
use App\Mail\TicketIssued;
use App\Models\PendingRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
class CivitasRegistrationTest extends TestCase { use RefreshDatabase;
 public function test_civitas_requires_ub_email_and_receives_ticket_without_qr():void {
  config(['app.registration_open'=>true,'app.registration_mail_verified'=>true]);
  Mail::fake();
  $this->post('/daftar/civitas/otp',['name'=>'Civitas Uji','email'=>'uji@gmail.com','phone'=>'081234567899'])->assertSessionHasErrors('email');
  $this->post('/daftar/civitas/otp',['name'=>'Civitas Uji','email'=>'uji@student.ub.ac.id','phone'=>'081234567899'])->assertRedirect('/daftar');
  Mail::assertSent(RegistrationOtp::class);
  $pending=PendingRegistration::first(); $pending->update(['otp_hash'=>Hash::make('123456')]);
  $response=$this->withSession(['registration_pending'=>$pending->id])->post('/daftar',['otp'=>'123456']);
  $response->assertOk()->assertSee('Pendaftaran Civitas UB berhasil');
  Mail::assertSent(TicketIssued::class,fn($mail)=>$mail->ticket->registration_type==='civitas_ub' && $mail->render() && !str_contains($mail->render(),'ticket-qr.png'));
  $this->assertDatabaseHas('tickets',['email'=>'uji@student.ub.ac.id','registration_type'=>'civitas_ub','nim'=>null]);
 }
}
