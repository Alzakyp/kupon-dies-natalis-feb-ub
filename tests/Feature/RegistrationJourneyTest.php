<?php
namespace Tests\Feature;
use App\Mail\RegistrationOtp;
use App\Mail\TicketIssued;
use App\Models\Batch;
use App\Models\PendingRegistration;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
class RegistrationJourneyTest extends TestCase {
    use RefreshDatabase;
    public function test_registration_requires_open_gate_and_allocates_one_coupon_after_otp(): void {
        Mail::fake();
        $batch=Batch::create(['name'=>'Dies Natalis','active'=>true,'expires_at'=>now()->addDays(7)]);
        $coupon=$batch->coupons()->create(['code'=>'FEB65-LUSTRUM-REG123']);
        \App\Models\StudentRegistry::create(['nim'=>'000123','name'=>'Test','education_level'=>'S1','study_program'=>'Akuntansi','registration_type'=>'active_student']);
        $this->post('/daftar/otp',['email'=>'test@example.com','phone'=>'081234567890'])->assertNotFound();
        config(['app.registration_open'=>true]);
        $this->post('/daftar/otp',['email'=>'test@example.com','phone'=>'081234567890'])->assertNotFound();
        config(['app.registration_mail_verified'=>true]);
        $this->post('/daftar/lookup',['type'=>'active_student','nim'=>'000123'])->assertRedirect();
        $this->post('/daftar/otp',['email'=>'test@example.com','phone'=>'081234567890'])->assertRedirect();
        $otp=null; Mail::assertSent(RegistrationOtp::class,function($mail) use (&$otp){$otp=$mail->otp;return true;});
        $this->post('/daftar',['otp'=>'000000' === $otp ? '999999':'000000'])->assertSessionHasErrors();
        $this->assertSame(1,PendingRegistration::firstOrFail()->otp_attempts);
        $this->post('/daftar',['otp'=>$otp])->assertOk()->assertSee('Tiket Anda siap');
        $ticket=Ticket::firstOrFail();
        $this->assertNull($ticket->coupon_id);
        $this->assertSame('6281234567890',$ticket->phone);
        Mail::assertSent(TicketIssued::class);
    }
}
