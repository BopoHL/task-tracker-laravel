<?php

namespace App\Http\Controllers\Projects;

use App\DTO\Projects\ProjectDTO;
use App\Exceptions\InvalidOperationException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\AddUserToProjectRequest;
use App\Http\Requests\Projects\ProjectRequest;
use App\Http\Resources\Projects\ProjectResource;
use App\Http\Resources\Projects\UserProjectResource;
use App\Http\Resources\Users\ProjectUserResource;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    /**
     * @param ProjectService $projectService
     */
    public function __construct(
        private readonly ProjectService $projectService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     * @throws NotFoundException
     */
    public function index(): AnonymousResourceCollection
    {
        $projects = $this->projectService->getAllUserProjects();
        return UserProjectResource::collection($projects);
    }

    /**
     * Show the form for creating a new resource.
     * @throws NotFoundException
     */
    public function store(ProjectRequest $request): ProjectResource
    {
        $validated = $request->validated();
        $project = $this->projectService
            ->createProject(
                projectDTO: ProjectDTO::fromArray($validated),
            );
        return new ProjectResource($project);
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(int $projectId): ProjectResource
    {
        $project = $this->projectService
            ->getUserProjectById(
                projectId: $projectId,
                relatedTables: ['tasks.assigner', 'users']
            );
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(ProjectRequest $request, int $projectId): ProjectResource
    {
        $validated = $request->validated();

        $project = $this->projectService
            ->updateUserProject(
                projectDTO: ProjectDTO::fromArray($validated),
                projectId: $projectId,
            );
        return new ProjectResource($project);
    }


    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(int $projectId): JsonResponse
    {
        $result = $this->projectService
            ->deleteUserProject(
                projectId: $projectId
            );
        return response()->json(['message' => $result]);
    }

    /**
     * @throws NotFoundException|InvalidOperationException
     */
    public function addMember(
        int                     $projectId,
        AddUserToProjectRequest $request,
    ): AnonymousResourceCollection
    {
        $validated = $request->validated();

        $projectUsers = $this->projectService->addUserToProject(
            userEmail: $validated['email'],
            role: $validated['role'],
            projectId: $projectId,
        );

        return ProjectUserResource::collection($projectUsers);
    }
}
