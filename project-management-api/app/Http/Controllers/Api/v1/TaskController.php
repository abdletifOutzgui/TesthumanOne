<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks for the authenticated user's projects.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {

        $tasksQuery = Task::with('project')->whereHas('project', function ($query) {
            $query->where('user_id', auth()->id()); 
        });

        if ($request->has('status')) {
            $tasksQuery->where('status', $request->status);
        }

        $tasks = $tasksQuery->paginate(10);

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created task for the authenticated user's project.
     *
     * @param StoreTaskRequest $request
     * @return TaskResource
     */
    public function store(StoreTaskRequest $request): TaskResource
    {
        $project = Project::where('user_id', auth()->id())->findOrFail($request->project_id);

        $task = $project->tasks()->create($request->validated());

        return new TaskResource($task->load('project'));
    }

    /**
     * Display the specified task.
     *
     * @param Task $task
     * @return TaskResource
     */
    public function show(Task $task): TaskResource
    {
        Gate::authorize('view', $task->project);

        return new TaskResource($task);
    }

    /**
     * Update the specified task in storage.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return TaskResource
     */
    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        Gate::authorize('update', $task->project);

        $task->update($request->validated());

        return new TaskResource($task);
    }

    /**
     * Remove the specified task from storage.
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task): Response
    {
        Gate::authorize('delete', $task->project);

        $task->delete();

        return response()->noContent();
    }
}
