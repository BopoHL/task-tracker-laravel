<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Tasks\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'date_of_birth' => $this->resource->date_of_birth,
            'avatar_url' => $this->resource->avatar_url,
            'role' => $this->resource->pivot->role,
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),];
    }
}
