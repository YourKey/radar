<?php

namespace Tests\Feature;

use App\Actions\CreateUserApiToken;
use App\Jobs\parseGuzzleJob;
use App\Models\Page;
use App\Models\Project;
use App\Models\Snapshot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreatesApplication;
use Tests\TestCase;

class SnapshotsTest extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /*
     * Если открыть несуществующую страницу snapshots, будет 404
     */
    public function test_not_found_snapshots_page_return_404(): void
    {
        $user = User::factory()->create();
        $project = $user->projects()->create(
            Project::factory()->make()->toArray()
        );

        $response = $this->actingAs($user)->get(route('projects.show', $project).'/123');

        $response->assertStatus(404);
    }

    /*
    * Юзер может открыть созданную страницу snapshots в проекте
    */
    public function test_user_can_see_created_snapshots_page(): void
    {
        $user = User::factory()->create();
        $project = $user->projects()->create(
            Project::factory()->make()->toArray()
        );
        $page = $project->pages()->create(
            Page::factory()->make()->toArray()
        );

        $response = $this->actingAs($user)->get(route('projects.snapshots', [$project, $page]));

        $response->assertStatus(200);
        $response->assertViewIs('projects.snapshots');
    }

    /*
     * Тест просмотра страницы snapshots, если у нас 0 snapshot
     */
    public function test_view_diff_without_snapshots(): void
    {
        $user = User::factory()->create();
        $project = $user->projects()->create(
            Project::factory()->make()->toArray()
        );
        $page = $project->pages()->create(
            Page::factory()->make()->toArray()
        );

        $response = $this->actingAs($user)->get(route('projects.snapshots', [$project, $page]));

        $response->assertStatus(200);
        $response->assertSeeText('0 snapshots');
        $this->assertNull($response['diff']['diff']);
        $this->assertNull($response['diff']['old']);
        $this->assertNull($response['diff']['new']);
    }

    /*
     * Тест просмотра страницы snapshots, если у нас один snapshot
     */
    public function test_view_diff_with_one_snapshot(): void
    {
        $user = User::factory()->create();
        $project = $user->projects()->create(
            Project::factory()->make()->toArray()
        );
        $page = $project->pages()->create(
            Page::factory()->make()->toArray()
        );
        $page->snapshots()->create(
            Snapshot::factory()->make()->toArray()
        );

        $response = $this->actingAs($user)->get(route('projects.snapshots', [$project, $page]));

        $response->assertStatus(200);
        $response->assertSeeText('Actual content');
        $this->assertNull($response['diff']['diff']);
        $this->assertNull($response['diff']['old']);
        $this->assertArrayHasKey('data', $response['diff']['new']);
    }

    /*
     * Тест просмотра страницы snapshots, если у нас 2 snapshot
     */
    public function test_view_diff_with_two_snapshots(): void
    {
        $user = User::factory()->create();
        $project = $user->projects()->create(
            Project::factory()->make()->toArray()
        );
        $page = $project->pages()->create(
            Page::factory()->make()->toArray()
        );
        $page->snapshots()->createMany([
            Snapshot::factory()->make()->toArray(),
            Snapshot::factory()->make()->toArray(),
        ]);

        $response = $this->actingAs($user)->get(route('projects.snapshots', [$project, $page]));

        $response->assertStatus(200);
        $response->assertSeeText('2 snapshots');
        $response->assertSeeText('Actual content');
        $this->assertNotNull($response['diff']['diff']);
        $this->assertArrayHasKey('data', $response['diff']['old']);
        $this->assertArrayHasKey('data', $response['diff']['new']);
    }

    /*
   * Проверка запуска создания snapshot через api
   */
    public function test_dispatch_job_for_create_snapshot_from_api(): void
    {
        $this->expectsJobs(parseGuzzleJob::class);
        $user = User::factory()->create();

        $this->actingAs($user);

        $token = (new CreateUserApiToken())->handle();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $page = Page::factory()->create(['project_id' => $project->id, 'url' => 'https://visasam.ru/emigration/canadausa/kak-poluchit-green-card-usa.html']);

        $response = $this->post(route('api.v1.snapshots.store'), $page->toArray(), ["Authorization" => "Bearer {$token}", "Accept" => "application/json"]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => '200',
            'message' => 'Страница отправлена на проверку',
        ]);
    }
}
