<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_user_tasks()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        Task::factory()->count(5)->create(['project_id' => $project->id]);

        $this->actingAs($user, 'api');
        $response = $this->json('GET', route('tasks.index'));
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    public function test_store_creates_task_for_authenticated_user()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user, 'api');

        $data = [
            'name' => 'New Task',
            'description' => 'Task description',
            'status' => 'pending',
            'project_id' => $project->id,
        ];

        $response = $this->json('POST', route('tasks.store'), $data);
        $response->assertStatus(201);
        $response->assertJsonFragment($data);
        
        $this->assertDatabaseHas('tasks', ['name' => 'New Task']);
    }

    public function test_show_returns_task_for_authenticated_user()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        $this->actingAs($user, 'api');
        $response = $this->json('GET', route('tasks.show', $task));
        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $task->id, 'name' => $task->name]);
    }

    public function test_update_updates_task_for_authenticated_user()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        $data = [
            'name' => 'Updated Task',
            'description' => 'Updated description',
            'status' => 'completed',
        ];

        $this->actingAs($user, 'api');
        $response = $this->json('PUT', route('tasks.update', $task), $data);
        $response->assertStatus(200);
        $response->assertJsonFragment($data);
        $this->assertDatabaseHas('tasks', ['name' => 'Updated Task']);
    }

    public function test_destroy_deletes_task_for_authenticated_user()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        $this->actingAs($user, 'api');
        $response = $this->json('DELETE', route('tasks.destroy', $task));
        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_unauthorized_access_to_tasks_from_other_projects()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user1->id]);
        $task = Task::factory()->create(['project_id' => $project->id]);

        $this->actingAs($user2, 'api');
        $response = $this->json('GET', route('tasks.show', $task));
        $response->assertStatus(403);

        $response = $this->json('DELETE', route('tasks.destroy', $task));
        $response->assertStatus(403);
    }
}
