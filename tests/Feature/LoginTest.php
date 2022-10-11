<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Tests\CreatesApplication;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * Работает ли Post-запрос для регистрации пользователя
     *
     * @return void
     */
    public function test_user_can_register_with_correct_credentials(): void
    {
        $user = User::factory()->make()->toArray();
        $user['password_confirmation'] = $user['password'] = bcrypt('password');

        $response = $this->post(route('register'), $user);

        $user = User::where('email', $user['email'])->first();

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    /*
     * Открывается ли страница логина
     */
    public function test_user_can_view_a_login_form(): void
    {
        $response = $this->get(route('login'));

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    /*
     * Редиректит ли с логин страницы, если мы уже залогинились
     */
    public function test_user_cannot_view_a_login_form_when_authenticated(): void
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect('/');
    }

    /*
     * Логин с неправильным паролем не проходит
     */
    public function test_user_cannot_login_with_incorrect_password(): void
    {
        User::factory()->create(['email' => 'test@test.com']);

        $response = $this->from(route('login'))->post(route('login'), [
            'email' => 'test@test.com',
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /*
     * Кнопка «remember me» работает
     */
    public function test_remember_me_functionality(): void
    {
        $user = User::factory()->create(['password' => bcrypt($password = 'password')]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));
    }
}
