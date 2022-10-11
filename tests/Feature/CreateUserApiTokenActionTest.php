<?php

namespace Tests\Feature;

use App\Actions\CreateUserApiToken;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreatesApplication;
use Tests\TestCase;

class CreateUserApiTokenActionTest extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    /**
     * api_token создается корректно
     *
     * @return void
     */
    public function test_create_api_user_token(): void
    {
        $user = User::factory()->create();
        $this->assertNull($user->api_token);

        $login_user = $this->actingAs($user);
        $token = (new CreateUserApiToken())->handle();
        $this->assertIsString($token);
    }
}
