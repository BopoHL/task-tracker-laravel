<?php

namespace App\Http\Controllers\Tasks;

use App\DTO\Tasks\TaskDTO;
use App\Exceptions\InvalidOperationException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\TaskRequest;
use App\Http\Resources\Tasks\TaskCollection;
use App\Http\Resources\Tasks\TaskResource;
use App\Http\Resources\TaskUsersCollection;
use App\Http\Resources\Users\UserResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    /**
     * @param TaskService $taskService
     */

    public function __construct(private readonly TaskService $taskService)
    {

    }

    /**
     * @throws NotFoundException
     */
    public function index(int $projectId): AnonymousResourceCollection
    {
        $tasks = $this->taskService->getAllProjectTasks($projectId);
        return TaskResource::collection($tasks);
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(int $projectId, int $taskId): TaskResource
    {
        $task = $this->taskService
            ->getProjectTaskById(
                projectId: $projectId,
                taskId: $taskId,
//                relatedTables: ['tasks.assigner', 'users']
            );
        return new TaskResource($task);
    }

    /**
     * Show the form for creating a new resource.
     * @throws NotFoundException
     */
    public function store(TaskRequest $request, int $projectId): TaskResource
    {
        $validated = $request->validated();
        $task = $this->taskService
            ->createTask(
                TaskDTO::fromArray($validated),
                $projectId
            );
        return new TaskResource($task);
    }


    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(TaskRequest $request, int $projectId, int $taskId): TaskResource
    {
        $validated = $request->validated();
        $task = $this->taskService
            ->updateProjectTask(
                TaskDTO::fromArray($validated),
                projectId: $projectId,
                taskId: $taskId
            );
        return new TaskResource($task);
    }


    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(int $projectId, int $taskId): JsonResponse
    {
        $result = $this->taskService->deleteProjectTask(projectId: $projectId, taskId: $taskId);
        return response()->json(['message' => $result]);
    }

    /**
     * @param int $taskId
     * @param int $projectId
     * @param Request $request
     * @return UserResource
     * @throws NotFoundException
     */
    public function addAssigner(
        int                  $taskId,
        int                  $projectId,
        Request              $request,
    ): UserResource
    {
        $validated = $request->validate([
                'email' => 'required|email',
            ]
        );

        $email = $validated['email'];

        $assigner = $this->taskService->addAssigner($taskId, $projectId, $email);

        return new UserResource($assigner);
    }

}
