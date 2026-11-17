<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminStaffTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_staff_page_and_create_and_disable_staff(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $existingStaff = User::factory()->create(['name' => 'Budi Staff', 'email' => 'budi@feb.ub.ac.id', 'role' => 'staff']);

        // Admin can view staff page
        $res = $this->actingAs($admin)->get('/admin/staff');
        $res->assertOk();
        $res->assertSee('Akun petugas');
        $res->assertSee('Buat akun petugas');
        $res->assertSee('Budi Staff');
        $res->assertSee('budi@feb.ub.ac.id');
        $res->assertSee('Nonaktifkan');

        // Admin can create a new staff member
        $postRes = $this->actingAs($admin)->post('/admin/staff', [
            'name' => 'Siti Petugas',
            'email' => 'siti@feb.ub.ac.id',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);
        $postRes->assertRedirect();
        $this->assertDatabaseHas('users', [
            'name' => 'Siti Petugas',
            'email' => 'siti@feb.ub.ac.id',
            'role' => 'staff',
        ]);

        $newStaff = User::where('email', 'siti@feb.ub.ac.id')->firstOrFail();

        // Admin can disable staff
        $disableRes = $this->actingAs($admin)->post('/admin/staff/'.$newStaff->id.'/disable');
        $disableRes->assertRedirect();
        $this->assertSame('disabled', $newStaff->fresh()->role);
    }
}
