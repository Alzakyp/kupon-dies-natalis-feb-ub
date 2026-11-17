<?php

namespace Tests\Feature;

use App\Mail\RegistrationOtp;
use App\Models\StudentRegistry;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ManualAlumniTest extends TestCase
{
    use RefreshDatabase;

    public function test_unlisted_alumni_can_complete_otp_and_duplicate_nim_is_rejected(): void
    {
        config(['app.registration_open' => true, 'app.registration_mail_verified' => true]);
        Mail::fake();
        StudentRegistry::create(['nim'=>'001','name'=>'Reference','education_level'=>'Sarjana S1','study_program'=>'Akuntansi','registration_type'=>'alumni']);
        $this->post('/daftar/lookup',['type'=>'alumni','nim'=>'999123'])->assertRedirect();
        $this->get('/daftar')->assertSee('Lengkapi data alumni');
        $contact=['email'=>'alumni@example.com','phone'=>'081234567891','name'=>'Alumni Manual','education_level'=>'Sarjana S1','study_program'=>'Akuntansi'];
        $this->post('/daftar/otp',array_replace($contact,['study_program'=>'Invalid']))->assertSessionHasErrors('study_program');
        $this->post('/daftar/otp',$contact)->assertRedirect();
        $otp=null;
        Mail::assertSent(RegistrationOtp::class,function($m)use(&$otp){$otp=$m->otp;return true;});
        $this->travel(61)->seconds();
        $this->post('/daftar/otp/resend')->assertRedirect();
        Mail::assertSent(RegistrationOtp::class,2);
        Mail::assertSent(RegistrationOtp::class,function($m)use(&$otp){$otp=$m->otp;return true;});
        // Use the newest code after resend.
        $otp=Mail::sent(RegistrationOtp::class)->last()->otp;
        $this->post('/daftar',['otp'=>$otp])->assertOk();
        $ticket=Ticket::firstOrFail();
        $this->assertSame('999123',$ticket->nim);
        $this->assertNull($ticket->student_registry_id);
        $this->post('/cek-tiket',['barcode'=>$ticket->barcode])->assertSee('Alumni Manual')->assertSee('Akuntansi');
        $this->post('/daftar/lookup',['type'=>'alumni','nim'=>'999123'])->assertRedirect();
        $this->post('/daftar/otp',array_replace($contact,['email'=>'other@example.com','phone'=>'081234567892']))->assertSessionHasErrors('nim');
        $this->assertSame(1,Ticket::count());
    }
}
