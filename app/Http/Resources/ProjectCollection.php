<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'projects' => $this->collection->map(function ($project) {
                return [
                    'project_name' => $project->project_name,
                    'project_description' => $project->project_description,
                ];
            }),
        ];
    }
}
