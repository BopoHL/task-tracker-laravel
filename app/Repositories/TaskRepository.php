<?php

namespace App\Repositories;

use App\DTO\Tasks\TaskDTO;
use App\Interfaces\ITaskRepository;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TaskRepository implements ITaskRepository
{
    public function storeTask(Task $task): void
    {
        $task->save();
    }

    public function deleteTask(Task $task): void
    {
        $task->delete();
    }

    public function getProjectTaskById(Project $project, int $taskId): Task|null
    {
        return $project->tasks()->where('id', $taskId)->first();
    }

    public function getAllProjectTasks(Project $project): Collection
    {
        return $project->tasks()->get();
    }

    //Unused functional
//    public function getAllUserTasks(): LengthAwarePaginator
//    {
//        return DB::table('tasks')->paginate(50);
//    }
//
//    public function getTaskById(int $taskId, string|array $relatedTables): ?Task
//    {
//        /** @var Task|null $task */
//        $task = Task::with($relatedTables)->find($taskId);
//        return $task;
//    }
//
//    public function getTasksByProject(int $projectId, string|array $relatedTables): ?Task
//    {
//        /** @var Task|null $task */
//        $task = Task::with($relatedTables)->where('project_id', $projectId)->get();
//        return $task;
//    }
//
//    public function getTasksByAssigner(int $assignerId, string|array $relatedTables): ?Task
//    {
//        /** @var Task|null $task */
//        $task = Task::with($relatedTables)->where('assigner_id', $assignerId)->get();
//        return $task;
//    }
//
//    public function getTaskByName(string $taskName, string|array $relatedTables): ?Task
//    {
//        /** @var Task|null $task */
//        $task = Task::with($relatedTables)->where('task_name', $taskName)->first();
//        return $task;
//    }
//
//    public function getTasksByPriority(string $priority, string|array $relatedTables): ?Task
//    {
//        /** @var Task|null $task */
//        $task = Task::with($relatedTables)->where('priority', $priority)->get();
//        return $task;
//    }
//
//    public function getTasksByStatus(string $status, string|array $relatedTables): ?Task
//    {
//        /** @var Task|null $task */
//        $task = Task::with($relatedTables)->where('status', $status)->get();
//        return $task;
//    }
}
