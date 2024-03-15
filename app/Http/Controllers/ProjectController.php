<?php

namespace App\Http\Controllers;

use App\DTO\ProjectDTO;
use App\Exceptions\NotFoundException;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Services\AddUserToProjectService;
use App\Services\ProjectService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @param ProjectService $service
     */
    public function __construct(private readonly ProjectService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(): ProjectCollection
    {
        $projects = $this->service->getAllProjects();
        return new ProjectCollection($projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(ProjectRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $project = $this->service->createProject(ProjectDTO::fromArray($validated));
        return response()->json(new ProjectResource($project));
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(string $projectId): JsonResponse
    {
        $project = $this->service->getProjectById($projectId, ['tasks.assigner', 'users']);
        return response()->json(new ProjectResource($project));
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(ProjectRequest $request, string $projectId): JsonResponse
    {
        $validated = $request->validated();
        $project = $this->service->updateProject(ProjectDTO::fromArray($validated), $projectId);
        return response()->json(new ProjectResource($project));
    }

    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(string $projectId): JsonResponse
    {
        $result = $this->service->deleteProject($projectId);
        return response()->json(['message' => $result]);
    }

    /**
     * @throws NotFoundException
     */
    public function addMember(Request $request, $projectId, AddUserToProjectService $service): JsonResponse
    {
        $validated = $request->validate([
                'email' => 'required|email',
                'role' => 'required|string|in:owner,manager,contributor',
            ]
        );
        $project = $service->addUserToProject(userEmail: $validated['email'], role: $validated['role'], projectId: $projectId);
        return response()->json(new ProjectResource($project));
    }
}
