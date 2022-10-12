<?php

namespace Tests\Feature;

use App\Actions\CreateUserApiToken;
use App\Models\Page;
use App\Models\Project;
use App\Models\Snapshot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\CreatesApplication;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function test_projects_index_cannot_see_without_auth(): void
    {
        $response = $this->get(route('projects.index'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /*
     * Пользователь не может просматривать страницу создания без авторизации
     */
    public function test_user_cannot_create_project_without_authentication(): void
    {
        $response = $this->get(route('projects.create'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /*
     * Пользователь видит страницу создания проекта
     */
    public function test_user_sees_create_project_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('projects.create'));

        $response->assertStatus(200);
        $response->assertViewIs('projects.create');
    }

    /*
     * Пользователь может создавать проект
     * todo: переделать проверку создания на post запрос
     */
    public function test_user_can_see_created_project(): void
    {
        $user = User::factory()->create();
        $project = $user->projects()->create(
            Project::factory()->make(['user_id' => $user->id])->toArray()
        );

        $this->assertEquals($user->id, $project->user_id);

        $response = $this->actingAs($user)->get(route('projects.show', $project));

        $response->assertStatus(200);
        $response->assertViewIs('projects.show');
        $this->assertEquals('projects.show', Route::currentRouteName());
    }

    /*
    * Проверка создания проекта через api
    */
    public function test_store_project_from_api(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $token = (new CreateUserApiToken())->handle();
        $data = Project::factory()->make(['user_id' => $user->id])->toArray();
        $data['pages'] = [
            [
                'url' => 'https://visasam.ru/emigration/canadausa/sroki-podachi-na-green-card.html',
                'filters' => ['type' => 'html']
            ]
        ];

        $response = $this->post(route('api.v1.projects.store'), $data, ["Authorization" => "Bearer {$token}", "Accept" => "application/json"]);

        $this->assertEquals($user->projects()->count(), 1);
        $response->assertStatus(201);
        $response->assertJson([
            'redirect' => route('projects.show', $user->projects()->first()),
        ]);
    }

    /*
     * Пользователь не может смотреть чужие проекты
     */
    public function test_user_cannot_see_other_peoples_projects(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $project2 = $user2->projects()->create(
            Project::factory()->make()->toArray()
        );

        $response = $this->actingAs($user1)->get(route('projects.show', $project2));

        $response->assertStatus(403);
    }
}
