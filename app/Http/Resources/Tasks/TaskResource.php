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
            'task_id' => $this->resource->id,
            'task_name' => $this->resource->task_name,
            'task_description' => $this->resource->task_description,
            'project_id' => $this->resource->project_id,
            'project' => new ProjectResource($this->whenLoaded('project')),
            'assigner_id' => $this->resource->assigner_id,
            'assigner' => $this->resource->assigner ? new UserResource($this->whenLoaded('assigner')) : null,
            'status' => $this->resource->status,
            'priority' => $this->resource->priority,
            'deadline' => $this->resource->deadline,
        ];
    }
}
