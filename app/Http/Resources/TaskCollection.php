<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tasks' => $this->collection->map(function ($task) {
                return [
                    'task_id' => $task->id,
                    'task_name' => $task->task_name,
                    'task_description' => $task->task_description,
                    'project_id' => $task->project_id,
                    'assigner_id' => $task->assigner_id,
                    'status' => $task->status,
                    'priority' => $task->priority,
                    'deadline' => $task->deadline,
                ];
            }),
        ];
    }
}
