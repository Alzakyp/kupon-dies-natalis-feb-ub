<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\StudentRegistry;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResetTestRegistrationCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_resets_only_unredeemed_ticket_for_allowed_test_nim(): void
    {
        config(['app.env' => 'local']);
        $student = StudentRegistry::create(['nim' => '2231730129', 'name' => 'Al Zaky Putra Agzulla', 'education_level' => 'S1', 'study_program' => 'Akuntansi', 'registration_type' => 'active_student']);
        $batch = Batch::create(['name' => 'Test', 'active' => true, 'expires_at' => now()->addDays(7)]);
        $coupon = $batch->coupons()->create(['code' => 'RESET-1']);
        Ticket::create(['number' => 'FEB65-RESET', 'barcode' => str_repeat('r', 48), 'email' => 'reset@example.com', 'phone' => '6281210820130', 'coupon_id' => $coupon->id, 'student_registry_id' => $student->id, 'registration_type' => 'active_student']);

        $this->artisan('registration:reset-test 2231730129')->assertSuccessful();
        $this->assertDatabaseMissing('tickets', ['number' => 'FEB65-RESET']);
        $this->assertDatabaseHas('coupons', ['code' => 'RESET-1', 'redeemed_at' => null]);
    }
}
