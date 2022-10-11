<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\CreatesApplication;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /*
     * Восстановление пароля работает, письма отсылаются
     */
    public function test_user_receives_an_email_with_a_password_reset_link(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $token = DB::table('password_resets')->first();

        $this->assertNotNull($token);
        Notification::assertSentTo($user, ResetPassword::class, function ($notification, $channels) use ($token) {
            return Hash::check($notification->token, $token->token) === true;
        });
    }
}
