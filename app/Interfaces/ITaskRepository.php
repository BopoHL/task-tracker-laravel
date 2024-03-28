<?php

namespace App\Interfaces;

use App\DTO\Tasks\TaskDTO;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ITaskRepository
{
    public function getAllUserTasks(): LengthAwarePaginator;

    public function getTaskById(int $taskId, string|array $relatedTables): ?Task;

    public function getTasksByProject(int $projectId, string|array $relatedTables): ?Task;

    public function getTasksByAssigner(int $assignerId, string|array $relatedTables): ?Task;

    public function getTaskByName(string $taskName, string|array $relatedTables): ?Task;

    public function getTasksByPriority(string $priority, string|array $relatedTables): ?Task;

    public function getTasksByStatus(string $status, string|array $relatedTables): ?Task;

    public function storeTask(User $user, TaskDTO $taskDTO): Task;

}
