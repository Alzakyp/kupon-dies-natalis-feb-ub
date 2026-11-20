<?php
namespace Tests\Feature;
use App\Jobs\SendCampaignEmail;
use App\Models\CampaignRecipient;
use App\Services\CampaignDelivery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
class CampaignDeliveryTest extends TestCase { use RefreshDatabase;
 public function test_paused_campaign_does_not_dispatch_and_running_campaign_batches():void {
  Queue::fake(); foreach (range(1, 60) as $i) CampaignRecipient::create(['email'=>"campaign{$i}@example.com",'status'=>'draft']);
  app(CampaignDelivery::class)->dispatchBatch(); Queue::assertNothingPushed();
  \DB::table('campaign_controls')->where('id',1)->update(['running'=>true]); app(CampaignDelivery::class)->dispatchBatch();
  Queue::assertPushed(SendCampaignEmail::class,50); $this->assertSame(50,CampaignRecipient::where('status','queued')->count());
 }
 public function test_send_records_attempt_and_smtp_acceptance():void {
  Mail::fake(); \DB::table('campaign_controls')->where('id',1)->update(['running'=>true]);
  $r=CampaignRecipient::create(['email'=>'campaign@example.com','status'=>'queued']); app(CampaignDelivery::class)->send($r->id);
  $this->assertSame('sent',$r->fresh()->status); $this->assertDatabaseHas('campaign_attempts',['campaign_recipient_id'=>$r->id,'status'=>'sent']);
 }
}
