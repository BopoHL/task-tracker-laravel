<?php

namespace App\Http\Resources\Projects;

use App\Http\Resources\Tasks\TaskResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'project_name' => $this->resource->project_name,
            'project_description' => $this->resource->project_description,
            'project_id' => $this->resource->id,
//            'users' => $this->whenLoaded('users', function () {
//                return $this->users->map(function ($user) {
//                    return [
//                        'id' => $user->id,
//                        'name' => $user->name,
//                        'email' => $user->email,
//                        'avatar_url' => $user->avatar_url,
//                        'role' => $user->pivot->role,
//                    ];
//                });
//            }),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
