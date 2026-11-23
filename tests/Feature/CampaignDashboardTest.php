<?php

namespace Tests\Feature;

use App\Models\CampaignRecipient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CampaignDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_campaign_dashboard_requires_monitoring_auth(): void
    {
        $this->get('/monitoring/campaign')->assertOk()->assertSee('Kampanye Email Grand Fiesta')->assertSee('Password Monitoring');
        $this->post('/monitoring/campaign', ['password' => 'wrong'])->assertSessionHasErrors();
        $this->post('/monitoring/campaign', ['password' => 'febub2026'])->assertRedirect('/monitoring/campaign');
    }

    public function test_campaign_dashboard_renders_stats_and_pagination(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            CampaignRecipient::create([
                'email' => "student{$i}@example.com",
                'name' => "Student {$i}",
                'nim' => "202600{$i}",
                'status' => $i <= 5 ? 'sent' : 'draft',
            ]);
        }

        $res = $this->withSession(['monitoring_authenticated' => true])
            ->get('/monitoring/campaign');

        $res->assertOk()
            ->assertSee('Kampanye Email Grand Fiesta')
            ->assertSee('Total Sasaran')
            ->assertSee('15')
            ->assertSee('Diterima SMTP')
            ->assertSee('Menampilkan')
            ->assertSee('1–10')
            ->assertSee('data penerima');

        // Page 2
        $res2 = $this->withSession(['monitoring_authenticated' => true])
            ->get('/monitoring/campaign?page=2');

        $res2->assertOk()
            ->assertSee('11–15')
            ->assertSee('Student 15');
    }

    public function test_campaign_dashboard_filters_search_and_status(): void
    {
        CampaignRecipient::create(['email' => 'alumni_budi@example.com', 'name' => 'Budi Santoso', 'nim' => '1150203001', 'status' => 'draft']);
        CampaignRecipient::create(['email' => 'active_siti@example.com', 'name' => 'Siti Nurhaliza', 'nim' => '2350201001', 'status' => 'sent']);

        // Search query
        $res = $this->withSession(['monitoring_authenticated' => true])
            ->get('/monitoring/campaign?q=Budi');

        $res->assertOk()
            ->assertSee('Budi Santoso')
            ->assertDontSee('Siti Nurhaliza');

        // Status filter
        $resStatus = $this->withSession(['monitoring_authenticated' => true])
            ->get('/monitoring/campaign?status=sent');

        $resStatus->assertOk()
            ->assertSee('Siti Nurhaliza')
            ->assertDontSee('Budi Santoso');
    }

    public function test_campaign_control_toggles_running_state(): void
    {
        $this->post('/monitoring/campaign/control', ['running' => 1])->assertForbidden();

        $this->withSession(['monitoring_authenticated' => true])
            ->post('/monitoring/campaign/control', ['running' => 1])
            ->assertRedirect('/monitoring/campaign');

        $this->assertTrue((bool) DB::table('campaign_controls')->where('id', 1)->value('running'));

        $this->withSession(['monitoring_authenticated' => true])
            ->post('/monitoring/campaign/control', ['running' => 0])
            ->assertRedirect('/monitoring/campaign');

        $this->assertFalse((bool) DB::table('campaign_controls')->where('id', 1)->value('running'));
    }

    public function test_campaign_preview_renders_branded_email_mockup(): void
    {
        $this->get('/monitoring/campaign/preview')->assertRedirect('/monitoring/campaign');

        $res = $this->withSession(['monitoring_authenticated' => true])
            ->get('/monitoring/campaign/preview');

        $res->assertOk()
            ->assertSee('Pratinjau Email Blast')
            ->assertSee('FEB UB Grand Fiesta — Fun Walk & FEB Unity Concert')
            ->assertSee('Special Guest Star: KOTAK')
            ->assertSee('Gratis untuk Mahasiswa Aktif dan Alumni FEB UB')
            ->assertSee('100% GRATIS')
            ->assertDontSee('Seluruh rangkaian acara Grand Fiesta')
            ->assertSee('Daftar Sekarang (Gratis)')
            ->assertSee('Kembali ke Dashboard Kampanye');
    }
}
