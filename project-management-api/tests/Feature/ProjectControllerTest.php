<?php

namespace Tests\Feature1;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_projects_for_authenticated_user()
    {
        $user = User::factory()->create();
        $projects = Project::factory()->count(3)->create(['user_id' => $user->id]);

        $this->actingAs($user, 'api');

        $response = $this->json('GET', route('projects.index'));

        $response->assertStatus(200);
        $response->assertJsonCount(3); // Ensure three projects are returned
    }

    public function test_store_creates_project_for_authenticated_user()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'New Project',
            'start_date' => now(),
            'description' => 'A new project',
        ];

        $this->actingAs($user, 'api');

        $response = $this->json('POST', route('projects.store'), $data);

        $response->assertStatus(201);
        $response->assertJsonFragment($data); 

        $this->assertDatabaseHas('projects', ['name' => 'New Project']); 
    }

    public function test_show_project_when_user_has_permission()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'api');

        $response = $this->json('GET', route('projects.show', $project));

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $project->id]);
    }

    public function test_show_project_when_user_does_not_have_permission()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2, 'api');

        $response = $this->json('GET', route('projects.show', $project));

        $response->assertStatus(403); 
    }

    public function test_update_project_when_user_has_permission()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $data = [
            'name' => 'Updated Project',
            'start_date' => now(),
            'description' => 'Updated project description',
        ];

        $this->actingAs($user, 'api');

        $response = $this->json('PUT', route('projects.update', $project), $data);

        $response->assertStatus(200);
        $response->assertJsonFragment($data);
        $this->assertDatabaseHas('projects', ['name' => 'Updated Project']); 
    }

    public function test_update_project_when_user_does_not_have_permission()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user1->id]);

        $data = [
            'name' => 'Updated Project',
            'start_date' => now(),
            'description' => 'Updated project description',
        ];

        $this->actingAs($user2, 'api');

        $response = $this->json('PUT', route('projects.update', $project), $data);

        $response->assertStatus(403); 
    }

    public function test_destroy_project_when_user_has_permission()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'api');

        Gate::authorize('delete', $project);

        $response = $this->json('DELETE', route('projects.destroy', $project));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
    
    public function test_destroy_project_when_user_does_not_have_permission()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user1->id]);

        $this->actingAs($user2, 'api');

        $response = $this->json('DELETE', route('projects.destroy', $project));

        $response->assertStatus(403);
    }
}
