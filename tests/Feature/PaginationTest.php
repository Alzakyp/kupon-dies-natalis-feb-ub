<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_batch_pagination_uses_styled_links_and_preserves_filter(): void
    {
        $batch = Batch::create(['name' => 'Pagination', 'active' => true, 'expires_at' => now()->addDays(7)]);
        for ($i = 0; $i < 51; $i++) {
            $batch->coupons()->create(['code' => 'PAGE-'.$i]);
        }

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->get('/admin/batches/'.$batch->id.'?filter=unredeemed')
            ->assertOk()
            ->assertSee('class="pagination"', false)
            ->assertSee('filter=unredeemed&amp;page=2', false)
            ->assertDontSee('<svg', false);
    }
}
