<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * This method returns a paginated list of projects belonging to the authenticated user,
     * ordered by the project start date.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $cacheKey = 'projects_' . auth()->id();

        $projects = Cache::remember($cacheKey, now()->addMinutes(10), function () {
            return Project::query()
                        ->where('user_id', auth()->id())
                        ->orderBy('start_date')
                        ->paginate(10);
        });

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * This method stores a new project in the database associated with the authenticated user.
     *
     * @param  \App\Http\Requests\Project\StoreProjectRequest  $request
     * @return \App\Http\Resources\ProjectResource
     */
    public function store(StoreProjectRequest $request): ProjectResource
    {
        $project = auth()->user()->projects()->create($request->validated());

        Cache::forget('projects_' . auth()->id());

        return new ProjectResource($project);
    }

     /**
     * Display the specified resource.
     *
     * This method shows the details of a specific project.
     * It checks the user's authorization to view the project.
     *
     * @param  \App\Models\Project  $project
     * @return \App\Http\Resources\ProjectResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Project $project): ProjectResource
    {
        Gate::authorize('view', $project);

        $project->load('tasks');

        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * This method updates an existing project with the provided data.
     * It checks the user's authorization to update the project before proceeding.
     *
     * @param  \App\Http\Requests\Project\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \App\Http\Resources\ProjectResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateProjectRequest $request, Project $project): ProjectResource
    {
        Gate::authorize('update', $project);

        $project->update($request->validated());

        Cache::forget('projects_' . auth()->id());

        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * This method deletes a project from the database after checking if the user is authorized
     * to delete the project.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Project $project): Response
    {
        Gate::authorize('delete', $project);
        
        $project->delete();

        Cache::forget('projects_' . auth()->id());

        return response()->noContent();
    }
}
