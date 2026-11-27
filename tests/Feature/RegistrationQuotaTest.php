<?php
namespace Tests\Feature;
use App\Models\Ticket;
use App\Services\RegistrationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
class RegistrationQuotaTest extends TestCase
{
    use RefreshDatabase;
    public function test_global_limit_is_enforced_when_completing_otp(): void
    {
        Mail::fake();
        $service = app(RegistrationService::class);
        $pending = $service->requestOtp('quota@ub.ac.id','081234567890',null,'civitas_ub',['name'=>'Quota']);
        $otp = \App\Models\EmailDeliveryLog::where('pending_registration_id',$pending->id)->value('otp_plaintext');
        foreach (array_chunk(range(1,6000),500) as $ids) {
            Ticket::insert(array_map(fn($i)=>['number'=>"Q$i",'barcode'=>"Q$i",'email'=>"q$i@example.com",'phone'=>"628$i"],$ids));
        }
        $this->assertFalse(RegistrationService::available());
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Kuota pendaftaran telah penuh.');
        $service->complete($pending->id,$otp);
    }
}
