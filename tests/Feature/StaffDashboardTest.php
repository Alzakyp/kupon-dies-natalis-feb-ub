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

    public function test_staff_ticket_detail_shows_study_program_and_student_info(): void
    {
        $batch = Batch::create(['name' => 'Event', 'active' => true, 'expires_at' => now()->addDays(7)]);
        $coupon = $batch->coupons()->create(['code' => 'TICKET-INFO-1']);
        $student = \App\Models\StudentRegistry::create([
            'nim' => '2231730129',
            'name' => 'Al Zaky Putra',
            'education_level' => 'S1',
            'study_program' => 'Akuntansi',
            'registration_type' => 'active_student',
        ]);
        $ticket = Ticket::create([
            'number' => 'FEB65-DETAIL',
            'barcode' => str_repeat('y', 48),
            'email' => 'zaky@example.com',
            'phone' => '6281210820130',
            'coupon_id' => $coupon->id,
            'student_registry_id' => $student->id,
            'registration_type' => 'active_student',
        ]);
        $staff = User::factory()->create(['role' => 'staff']);

        $res = $this->actingAs($staff)->get('/staff/tickets/'.$ticket->id);
        $res->assertOk();
        $res->assertSee('Al Zaky Putra');
        $res->assertSee('Akuntansi');
        $res->assertSee('2231730129');
        $res->assertSee('Konfirmasi check-in');
    }

    public function test_staff_can_view_thermal_print_template_with_batch_qr_and_lottery_number(): void
    {
        $batch = Batch::create(['name' => 'Dies65', 'active' => true, 'expires_at' => now()->addDays(7)]);
        $coupon = $batch->coupons()->create(['code' => 'TICKET-PRINT-01']);
        $student = \App\Models\StudentRegistry::create([
            'nim' => '2231730129',
            'name' => 'Al Zaky Putra',
            'education_level' => 'S1',
            'study_program' => 'Akuntansi',
            'registration_type' => 'active_student',
        ]);
        $ticket = Ticket::create([
            'number' => 'FEB65-PRINTTEST',
            'barcode' => str_repeat('z', 48),
            'email' => 'zaky@example.com',
            'phone' => '6281210820130',
            'coupon_id' => $coupon->id,
            'student_registry_id' => $student->id,
            'registration_type' => 'active_student',
            'checked_in_at' => now(),
        ]);
        $staff = User::factory()->create(['role' => 'staff']);

        $res = $this->actingAs($staff)->get('/staff/tickets/'.$ticket->id.'/print');
        $res->assertOk();
        $res->assertSee('NO. UNDIAN');
        $res->assertSee('#'.str_pad($coupon->id, 4, '0', STR_PAD_LEFT));
        $res->assertSee('Al Zaky Putra');
        $res->assertSee('Akuntansi');
        $res->assertSee('47 × 31 mm');
    }
}
