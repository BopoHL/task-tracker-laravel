<?php

namespace App\Services;

use App\DTO\TaskDTO;
use App\Exceptions\NotFoundException;
use App\Interfaces\ITaskRepository;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{

    public function __construct(private readonly ITaskRepository $repository)
    {

    }

    public function getAllTasks(): Collection
    {
        return $this->repository->getAllTasks();
    }

    /**
     * @throws NotFoundException
     */
    public function getTaskById(string $taskId, string|array $relatedTables = []): Task
    {
        $task = $this->repository->getTaskById($taskId, $relatedTables);
        if ($task === null) {
            throw new NotFoundException('Task' . __('messages.with_id_not_found'));
        }

        return $task;
    }

    /**
     * @throws NotFoundException
     */
    public function getTaskByName(string $taskName, string|array $relatedTables = []): Task
    {
        $task = $this->repository->getTaskByName($taskName, $relatedTables);
        if ($task === null) {
            throw new NotFoundException('Task' . __('messages.with_name_not_found'));
        }
        return $task;
    }

    public function createTask(TaskDTO $taskDTO): Task
    {
        return $this->repository->storeTask($taskDTO);
    }

    /**
     * @throws NotFoundException
     */
    public function updateTask(TaskDTO $taskDTO, string $taskId): Task
    {
        $task = $this->getTaskById($taskId);
        $taskName = $taskDTO->getTaskName();
        $taskDescription = $taskDTO->getTaskDescription();

        if ($taskName !== null) {
            $task->task_name = $taskName;
        }

        if ($taskDescription !== null) {
            $task->task_description = $taskDescription;
        }

        $task->save();
        return $task;
    }

    /**
     * @throws NotFoundException
     */
    public function deleteTask(string $taskId): string
    {
        $task = $this->getTaskById($taskId);

        $task->delete();
        return __('messages.delete_successful');
    }
}


