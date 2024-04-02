<?php

namespace App\Interfaces;

use App\DTO\Tasks\TaskDTO;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ITaskRepository
{
//    Unused functional
//    public function getAllUserTasks();
//
//    public function getTaskById(int $taskId, string|array $relatedTables);
//
//    public function getTasksByProject(int $projectId, string|array $relatedTables);
//
//    public function getTasksByAssigner(int $assignerId, string|array $relatedTables);
//
//    public function getTaskByName(string $taskName, string|array $relatedTables);
//
//    public function getTasksByPriority(string $priority, string|array $relatedTables);
//
//    public function getTasksByStatus(string $status, string|array $relatedTables);

    public function storeTask(Task $task);

    public function deleteTask(Task $task);

    public function getProjectTaskById(Project $project, int $taskId);

    public function getAllProjectTasks(Project $project);


}
