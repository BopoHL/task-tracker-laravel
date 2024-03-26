<?php

namespace App\Http\Resources\Tasks;

use App\Http\Resources\Projects\ProjectResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'task_name' => $this->task_name,
            'task_description' => $this->task_description,
            'project_id' => $this->project_id,
            'project' => new ProjectResource($this->whenLoaded('project')),
            'assigner_id' => $this->assigner_id,
            'assigner' => $this->assigner ? new UserResource($this->whenLoaded('assigner')) : null,
            'status' => $this->status,
            'priority' => $this->priority,
            'deadline' => $this->deadline,
        ];
    }
}
