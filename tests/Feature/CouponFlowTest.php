<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CouponFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_creates_unique_seven_day_coupons_and_guests_cannot_export(): void
    {
        $this->post('/admin/batches', ['name' => 'A', 'quantity' => 2])->assertRedirect('/admin/login');
        $this->actingAs(User::factory()->create())->post('/admin/batches', ['name' => 'A', 'quantity' => 2])->assertRedirect();
        $batch = Batch::firstOrFail();
        $this->assertCount(2, $batch->coupons);
        $this->assertCount(2, $batch->coupons->pluck('code')->unique());
        $this->assertTrue($batch->coupons->every(fn ($c) => str_starts_with($c->code, 'FEB65-LUSTRUM-')));
        $this->assertEqualsWithDelta(7 * 86400, $batch->created_at->diffInSeconds($batch->expires_at), 2);
        auth()->logout();
        $this->get('/admin/batches/'.$batch->id.'/export')->assertRedirect('/admin/login');
    }

    public function test_redemption_is_single_use_and_records_ip(): void
    {
        $batch = Batch::create(['name' => 'A', 'expires_at' => now()->addDays(7), 'active' => true]);
        $coupon = $batch->coupons()->create(['code' => 'FEB65-LUSTRUM-TEST123']);
        DB::table('settings')->insert(['key' => 'redemption_password', 'value' => Hash::make('febub65')]);
        $this->get('/c/'.$coupon->code)->assertSee('VALID')->assertSee('Gunakan Kupon');
        $this->post('/c/'.$coupon->code, ['password' => 'incorrect'])->assertSessionHasErrors();
        $this->post('/c/'.$coupon->code, ['password' => 'febub65'])->assertRedirect();
        $this->assertNotNull($coupon->fresh()->redeemed_at);
        $this->assertNotNull($coupon->fresh()->redeemed_ip);
        $this->post('/c/'.$coupon->code, ['password' => 'febub65'])->assertSessionHasErrors();
        $this->get('/c/'.$coupon->code)->assertSee('SUDAH DIGUNAKAN')->assertDontSee('Gunakan Kupon');
    }

    public function test_five_failed_attempts_lock_coupon_and_batch_can_be_deactivated(): void
    {
        $batch = Batch::create(['name' => 'A', 'expires_at' => now()->addDays(7), 'active' => true]);
        $coupon = $batch->coupons()->create(['code' => 'FEB65-LUSTRUM-LOCK123']);
        DB::table('settings')->insert(['key' => 'redemption_password', 'value' => Hash::make('febub65')]);
        foreach (range(1, 5) as $attempt) $this->post('/c/'.$coupon->code, ['password' => 'wrong'])->assertSessionHasErrors();
        $this->post('/c/'.$coupon->code, ['password' => 'febub65'])->assertSessionHasErrors();
        $this->assertNull($coupon->fresh()->redeemed_at);
        $this->actingAs(User::factory()->create())->post('/admin/batches/'.$batch->id.'/deactivate')->assertRedirect();
        $this->get('/c/'.$coupon->code)->assertSee('NONAKTIF')->assertDontSee('Gunakan Kupon');
    }
}
