<?php

namespace App\Http\Controllers\Projects;

use App\DTO\ProjectDTO;
use App\Exceptions\InvalidOperationException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Projects\ProjectRequest;
use App\Http\Resources\Projects\ProjectCollection;
use App\Http\Resources\Projects\ProjectResource;
use App\Http\Resources\ProjectUsersCollection;
use App\Services\AddUserToProjectService;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function index(int $userId): ProjectCollection
    {
        $projects = $this->projectService->getAllUserProjects($userId);
        return new ProjectCollection($projects);
    }

    /**
     * Show the form for creating a new resource.
     * @throws NotFoundException
     */
    public function store(int $userId, ProjectRequest $request): ProjectResource
    {
        $validated = $request->validated();
        $project = $this->projectService
            ->createProject(
                projectDTO: ProjectDTO::fromArray($validated),
                userId: $userId
            );
        return new ProjectResource($project);
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(int $userId, int $projectId): ProjectResource
    {
        $project = $this->projectService
            ->getUserProjectById(
                userId: $userId,
                projectId: $projectId,
                relatedTables: ['tasks.assigner', 'users']
            );
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(int $userId, ProjectRequest $request, int $projectId): ProjectResource
    {
        $validated = $request->validated();

        $project = $this->projectService
            ->updateUserProject(
                projectDTO: ProjectDTO::fromArray($validated),
                userId: $userId,
                projectId: $projectId,
            );
        return new ProjectResource($project);
    }


    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(int $userId, int $projectId): JsonResponse
    {
        $result = $this->projectService
            ->deleteUserProject(
                userId: $userId,
                projectId: $projectId
            );
        return response()->json(['message' => $result]);
    }

    /**
     * @throws NotFoundException|InvalidOperationException
     */
    public function addMember(
        int                     $userId,
        int                     $projectId,
        Request                 $request,
        AddUserToProjectService $service
    ): ProjectUsersCollection
    {
        $validated = $request->validate([
                'email' => 'required|email',
                'role' => 'required|string|in:owner,manager,contributor',
            ]
        );
        $projectUsers = $service->addUserToProject(
            managerId: $userId,
            userEmail: $validated['email'],
            role: $validated['role'],
            projectId: $projectId,
        );
        return new ProjectUsersCollection($projectUsers);
    }
}
