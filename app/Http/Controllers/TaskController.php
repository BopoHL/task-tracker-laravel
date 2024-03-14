<?php

namespace App\Http\Controllers;

use App\DTO\TaskDTO;
use App\Exceptions\NotFoundException;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @param TaskService $service
     */

    public function __construct(private readonly TaskService $service)
    {

    }

    public function index()
    {
        $tasks = $this->service->getAllTasks();
        return new TaskCollection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validated();
        $task = $this->service->createTask(TaskDTO::fromArray($validated));
        return response()->json(new TaskResource($task));
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(string $taskId): JsonResponse
    {
        $task = $this->service->getTaskById($taskId, 'tasks.assigner');
        return response()->json(new TaskResource($task));
    }


    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(Request $request, string $taskId)
    {
        $validated = $request->validated();
        $task = $this->service->updateTask(TaskDTO::fromArray($validated), $taskId);
        return response()->json(new TaskResource($task));
    }

    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(string $taskId)
    {
        $result = $this->service->deleteTask($taskId);
        return response()->json(['message' => $result]);
    }
}
