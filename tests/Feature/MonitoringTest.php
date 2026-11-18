<?php
namespace Tests\Feature;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class MonitoringTest extends TestCase { use RefreshDatabase;
 public function test_monitoring_requires_password_and_lists_delivery_state():void {
  config(['app.monitoring_password'=>'Strong-Monitor-2026!']);
  Ticket::create(['number'=>'MON-1','barcode'=>str_repeat('m',48),'email'=>'monitor@example.com','phone'=>'6281212345678','registration_type'=>'alumni','nim'=>'123']);
  $this->get('/monitoring')->assertOk()->assertSee('Password monitoring')->assertDontSee('monitor@example.com');
  $this->post('/monitoring',['password'=>'wrong'])->assertSessionHasErrors();
  $this->post('/monitoring',['password'=>'febub2026'])->assertRedirect('/monitoring');
  $this->get('/monitoring')->assertOk()->assertSee('monitor@example.com')->assertSee('Belum/gagal')->assertSee('Menunggu OTP');
 }
}
