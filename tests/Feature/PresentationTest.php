<?php

namespace Tests\Feature;

use Tests\TestCase;

class PresentationTest extends TestCase
{
    public function test_login_has_visible_labels_and_autocomplete(): void
    {
        $this->get('/admin/login')->assertOk()
            ->assertSee('Kelola kupon acara')
            ->assertSee('Email')
            ->assertSee('Password')
            ->assertSee('autocomplete="username"', false)
            ->assertSee('autocomplete="current-password"', false);
    }
}
