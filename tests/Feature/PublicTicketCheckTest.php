<?php
namespace Tests\Feature;
use App\Models\Batch;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class PublicTicketCheckTest extends TestCase {
 use RefreshDatabase;
 public function test_public_ticket_check_is_read_only(): void {
  $b=Batch::create(['name'=>'Check','active'=>true,'expires_at'=>now()->addDay()]);
  $c=$b->coupons()->create(['code'=>'CHECK-1']);
  $t=Ticket::create(['number'=>'FEB65-CHECK','barcode'=>str_repeat('q',48),'email'=>'check@example.com','phone'=>'6281212345678','coupon_id'=>$c->id]);
  $this->get('/cek-tiket')->assertOk()->assertSee('Cek QR tiket');
  $this->post('/cek-tiket',['barcode'=>$t->barcode])->assertOk()->assertSee('check@example.com')->assertSee('Mahasiswa Aktif')->assertDontSee('FEB65-CHECK')->assertDontSee('Status check-in');
  $this->assertNull($t->fresh()->checked_in_at);
 }
}
