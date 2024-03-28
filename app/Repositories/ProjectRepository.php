<?php

namespace App\Repositories;

use App\DTO\Projects\ProjectDTO;
use App\Interfaces\IProjectRepository;
use App\Models\Project;
use App\Models\User;

class ProjectRepository implements IProjectRepository
{
    public function getProjectById(int $projectId, string|array $relatedTables):
    ?Project
    {
        /** @var Project|null $project */
        $project = Project::with($relatedTables)->find($projectId);
        return $project;
    }

    public function getProjectByName(string $projectName, string|array $relatedTables):
    ?Project
    {
        /** @var Project|null $project */
        $project = Project::with($relatedTables)->where('project_name', $projectName)->first();
        return $project;
    }

    public function storeProject(Project $project): void
    {
        $project->save();
    }

    public function destroyProject(Project $project): void
    {
        $project->delete();
    }
}
