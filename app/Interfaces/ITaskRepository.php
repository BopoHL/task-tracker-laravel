<?php

namespace App\Interfaces;

use App\DTO\TaskDTO;
use App\Models\Task;

interface ITaskRepository
{
    public function getAllTasks();

    public function getTaskById(string $taskId, string|array $relatedTables): ?Task;

    public function getTasksByProject(string $projectId, string|array $relatedTables): ?Task;

    public function getTasksByAssigner(string $assignerId, string|array $relatedTables): ?Task;

    public function getTaskByName(string $taskName, string|array $relatedTables): ?Task;

    public function getTasksByPriority(string $priority, string|array $relatedTables): ?Task;

    public function getTasksByStatus(string $status, string|array $relatedTables): ?Task;

    public function storeTask(TaskDTO $taskDTO): Task;

}
