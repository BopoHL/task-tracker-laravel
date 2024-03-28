<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Projects\ProjectResource;
use App\Http\Resources\Tasks\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'date_of_birth' => $this->resource->date_of_birth,
            'avatar_url' => $this->resource->avatar_url,
//            'projects' => $this->whenLoaded('projects', function () {
//                return $this->projects->map(function ($project) {
//                    return [
//                        'project_id' => $project->id,
//                        'project_name' => $project->project_name,
//                        'project_description' => $project->project_description,
//                        'role' => $project->pivot->role,
//                    ];
//                });
//            }),
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
