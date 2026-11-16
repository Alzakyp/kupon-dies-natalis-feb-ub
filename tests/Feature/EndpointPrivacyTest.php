<?php

namespace Tests\Feature;

use Tests\TestCase;

class EndpointPrivacyTest extends TestCase
{
    public function test_root_and_admin_prefix_return_not_found(): void
    {
        $this->get('/')->assertNotFound();
        $this->get('/admin')->assertNotFound();
    }

    public function test_login_displays_official_brand_assets(): void
    {
        $this->get('/admin/login')->assertOk()
            ->assertSee('images/logo-ub.svg')
            ->assertSee('images/wordmark-feb.png')
            ->assertSee('images/logo-lustrum-65-clean.png');
    }
}
