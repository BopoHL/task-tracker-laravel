<?php

namespace App\Http\Resources\Projects;

use App\Http\Resources\Tasks\TaskResource;
use App\Http\Resources\Users\ProjectUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'project_id' => $this->resource->id,
            'project_name' => $this->resource->project_name,
            'project_description' => $this->resource->project_description,
            'role' => $this->resource->pivot->role,
            'users' => ProjectUserResource::collection($this->whenLoaded('users')),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
