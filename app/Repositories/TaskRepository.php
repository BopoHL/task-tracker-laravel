<?php

namespace App\Repositories;

use App\DTO\TaskDTO;
use App\Interfaces\ITaskRepository;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements ITaskRepository
{

    public function getAllTasks(): Collection
    {
        return Task::all();
    }

    public function getTaskById(string $taskId, string|array $relatedTables): ?Task
    {
        /** @var Task|null $task */
        $task = Task::with($relatedTables)->find($taskId);
        return $task;
    }

    public function getTasksByProject(string $projectId, string|array $relatedTables): ?Task
    {
        /** @var Task|null $task */
        $task = Task::with($relatedTables)->find($projectId);
        return $task;
    }

    public function getTasksByAssigner(string $assignerId, string|array $relatedTables): ?Task
    {
        /** @var Task|null $task */
        $task = Task::with($relatedTables)->find($assignerId);
        return $task;
    }

    public function getTaskByName(string $taskName, string|array $relatedTables): ?Task
    {
        /** @var Task|null $task */
        $task = Task::with($relatedTables)->where('task_name', $taskName)->first();
        return $task;
    }

    public function getTasksByPriority(string $priority, string|array $relatedTables): ?Task
    {
        /** @var Task|null $task */
        $task = Task::with($relatedTables)->where('priority', $priority)->first();
        return $task;
    }

    public function getTasksByStatus(string $status, string|array $relatedTables): ?Task
    {
        /** @var Task|null $task */
        $task = Task::with($relatedTables)->where('status', $status)->first();
        return $task;
    }
    public function storeTask(TaskDTO $taskDTO): Task
    {
        $task = new Task();
        $task->task_name = $taskDTO->getTaskName();
        $task->task_description = $taskDTO->getTaskDescription();
        $task->status = $taskDTO->getStatus();
        $task->priority = $taskDTO->getPriority();
        $task->deadline = $taskDTO->getDeadline();
        $task->project_id= $taskDTO->getProjectId();
        $task->assigner_id= $taskDTO->getAssignerId();
        $task->save();
        return $task;

    }
}
