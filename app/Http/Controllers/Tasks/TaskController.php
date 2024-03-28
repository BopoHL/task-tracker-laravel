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
use App\Services\AddUserToTaskService;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @param TaskService $taskService
     */

    public function __construct(private readonly TaskService $taskService)
    {

    }
//    public function index(): TaskCollection
//    {
//        $tasks = $this->service->getAllTasks();
//        return new TaskCollection($tasks);
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     */
////    public function store(TaskRequest $request): JsonResponse
////    {
////        $validated = $request->validated();
////        $task = $this->service->createTask(TaskDTO::fromArray($validated));
////        return response()->json(new TaskResource($task));
////    }
//    public function store(int $userId, TaskRequest $request): TaskResource
//    {
//        $validated = $request->validated();
//        $task = $this->service
//            ->createTask(
//                TaskDTO::fromArray($validated),
//                userId: $userId
//            );
//        return new TaskResource($task);
//    }
//
//    /**
//     * Display the specified resource.
//     * @throws NotFoundException
//     */
//    public function show(int $taskId): JsonResponse
//    {
//        $task = $this->service->getTaskById($taskId, ['assigner', 'project']);
//        return response()->json(new TaskResource($task));
//    }
//
//
//    /**
//     * Update the specified resource in storage.
//     * @throws NotFoundException
//     */
//    public function update(TaskRequest $request, int $taskId): JsonResponse
//    {
//        $validated = $request->validated();
//        $task = $this->service->updateTask(TaskDTO::fromArray($validated), $taskId);
//        return response()->json(new TaskResource($task));
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     * @throws NotFoundException
//     */
//    public function destroy(int $taskId): JsonResponse
//    {
//        $result = $this->service->deleteTask($taskId);
//        return response()->json(['message' => $result]);
//    }
    public function index(int $userId): TaskCollection
    {
        $tasks = $this->taskService->getAllUserTasks($userId);
        return new TaskCollection($tasks);
    }

    /**
     * Show the form for creating a new resource.
     * @throws NotFoundException
     */
    public function store(int $userId, TaskRequest $request): TaskResource
    {
        $validated = $request->validated();
        $task = $this->taskService
            ->createTask(
                TaskDTO::fromArray($validated),
                userId: $userId
            );
        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(int $userId, int $projectId, int $taskId): TaskResource
    {
        $task = $this->taskService
            ->getUserTaskById(
                userId: $userId,
                projectId: $projectId,
                taskId: $taskId,
                relatedTables: ['tasks.assigner', 'users']
            );
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(int $userId, TaskRequest $request, int $projectId, int $taskId): TaskResource
    {
        $validated = $request->validated();
        $task = $this->taskService
            ->updateUserTask(
                TaskDTO::fromArray($validated),
                userId: $userId,
                projectId: $projectId,
                taskId: $taskId
            );
        return new TaskResource($task);
    }


    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(int $userId, int $projectId, int $taskId): JsonResponse
    {
        $result = $this->taskService->deleteUserTask(userId: $userId, projectId: $projectId, taskId: $taskId);
        return response()->json(['message' => $result]);
    }

    /**
     * @throws NotFoundException|InvalidOperationException
     */
    public function addMember(
        int                     $userId,
        int                     $taskId,
        int                     $projectId,
        Request                 $request,
        AddUserToTaskService    $service
    ): TaskUsersCollection
    {
        $validated = $request->validate([
                'email' => 'required|email',
                'role' => 'required|string|in:owner,manager,contributor',
            ]
        );
        $taskUsers = $service->addUserToTask(
            userId: $userId,
            userEmail: $validated['email'],
            role: $validated['role'],
            projectId: $projectId,
            taskId: $taskId,
        );
        return new TaskUsersCollection($taskUsers);
    }

}
