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


}
