<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_dashboard_shows_scanner_and_ticket_counts(): void
    {
        $batch = Batch::create(['name' => 'Test', 'active' => true, 'expires_at' => now()->addDays(7)]);
        $coupon = $batch->coupons()->create(['code' => 'DASH-1']);
        Ticket::create(['number' => 'FEB65-DASH', 'barcode' => str_repeat('x', 48), 'email' => 'dash@example.com', 'phone' => '6281212345678', 'coupon_id' => $coupon->id]);
        $staff = User::factory()->create(['role' => 'staff']);

        $this->actingAs($staff)->get('/staff/scan')
            ->assertOk()->assertSee('Dashboard petugas')->assertSee('Scan QR tiket')
            ->assertSee('Total tiket')->assertSee('Belum check-in');
    }
}
