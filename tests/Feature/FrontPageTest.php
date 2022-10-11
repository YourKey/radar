<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FrontPageTest extends TestCase
{
    /**
     * Главная страница перекидывает на логин форму.
     *
     * @return void
     */
    public function test_user_cannot_view_frontpage_without_auth(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302);

        $response = $this->followingRedirects()->get('/');
        $response->assertViewIs('auth.login');
    }
}
