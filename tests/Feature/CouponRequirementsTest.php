<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use ZipArchive;

class CouponRequirementsTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_creates_valid_zip_with_png_and_csv_only_for_admin(): void
    {
        $admin = User::factory()->create();
        $batch = Batch::create(['name' => 'Batch 1', 'expires_at' => now()->addDays(7), 'active' => true]);
        $coupon = $batch->coupons()->create(['code' => 'FEB65-LUSTRUM-AAAA1111']);

        $this->get('/admin/batches/'.$batch->id.'/export')->assertRedirect('/admin/login');

        $response = $this->actingAs($admin)->get('/admin/batches/'.$batch->id.'/export');
        $response->assertOk();
        $this->assertEquals('application/zip', $response->headers->get('content-type'));

        $tmp = tempnam(sys_get_temp_dir(), 'test_zip_');
        file_put_contents($tmp, $response->streamedContent());
        $zip = new ZipArchive();
        $this->assertTrue($zip->open($tmp) === true);
        $this->assertNotFalse($zip->locateName($coupon->code.'.png'));
        $csv = $zip->getFromName('list_kupon.csv');
        $this->assertStringContainsString($coupon->code, $csv);
        $zip->close();
        @unlink($tmp);
    }

    public function test_setting_updates_redemption_password(): void
    {
        $admin = User::factory()->create();
        $batch = Batch::create(['name' => 'Batch 1', 'expires_at' => now()->addDays(7), 'active' => true]);
        $coupon = $batch->coupons()->create(['code' => 'FEB65-LUSTRUM-PWD123']);

        $this->actingAs($admin)->post('/admin/settings', [
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345',
        ])->assertRedirect();

        $this->post('/c/'.$coupon->code, ['password' => 'febub65'])->assertSessionHasErrors();
        $this->post('/c/'.$coupon->code, ['password' => 'secret12345'])->assertRedirect();
        $this->assertNotNull($coupon->fresh()->redeemed_at);
    }

    public function test_security_headers_and_noindex_are_present(): void
    {
        $batch = Batch::create(['name' => 'Batch 1', 'expires_at' => now()->addDays(7), 'active' => true]);
        $coupon = $batch->coupons()->create(['code' => 'FEB65-LUSTRUM-SEC123']);

        $response = $this->get('/c/'.$coupon->code);
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertSee('noindex', false);
        $response->assertDontSee('febub65');
    }
}
