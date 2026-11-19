<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonitoringTest extends TestCase
{
    use RefreshDatabase;

    public function test_monitoring_requires_password_and_lists_delivery_state(): void
    {
        config(['app.monitoring_password' => 'Strong-Monitor-2026!']);
        Ticket::create(['number' => 'MON-1', 'barcode' => str_repeat('m', 48), 'email' => 'monitor@example.com', 'phone' => '6281212345678', 'registration_type' => 'alumni', 'nim' => '123']);
        $this->get('/monitoring')->assertOk()->assertSee('Password monitoring')->assertDontSee('monitor@example.com');
        $this->post('/monitoring', ['password' => 'wrong'])->assertSessionHasErrors();
        $this->post('/monitoring', ['password' => 'febub2026'])->assertRedirect('/monitoring');
        $this->get('/monitoring')->assertOk()->assertSee('monitor@example.com')->assertSee('Belum/gagal')->assertSee('Menunggu OTP');
    }

    public function test_monitoring_pagination_ten_per_page_and_shows_data_count(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            Ticket::create([
                'number' => 'MON-' . str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'barcode' => md5((string) $i) . str_pad((string) $i, 16, '0', STR_PAD_LEFT),
                'email' => "user{$i}@example.com",
                'phone' => '62812123456' . str_pad((string) $i, 2, '0', STR_PAD_LEFT),
                'registration_type' => 'active_student',
                'nim' => '2026' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
            ]);
        }

        // Page 1
        $response = $this->withSession(['monitoring_authenticated' => true])
            ->get('/monitoring');

        $response->assertOk()
            ->assertSee('Menampilkan')
            ->assertSee('1–10')
            ->assertSee('15')
            ->assertSee('data peserta');

        // Page 2
        $page2 = $this->withSession(['monitoring_authenticated' => true])
            ->get('/monitoring?page=2');

        $page2->assertOk()
            ->assertSee('Menampilkan')
            ->assertSee('11–15')
            ->assertSee('15')
            ->assertSee('data peserta');
    }
}

