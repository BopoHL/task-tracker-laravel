<?php

namespace App\Repositories;

use App\DTO\ProjectDTO;
use App\Interfaces\IProjectRepository;
use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProjectRepository implements IProjectRepository
{

    public function getAllProjects(): LengthAwarePaginator
    {
        return DB::table('projects')->paginate(50);
    }

    public function getProjectById(string $projectId, string|array $relatedTables): ?Project
    {
        /** @var Project|null $project */
        $project = Project::with($relatedTables)->find($projectId);
        return $project;
    }

    public function getProjectByName(string $projectName, string|array $relatedTables): ?Project
    {
        /** @var Project|null $project */
        $project = Project::with($relatedTables)->where('project_name', $projectName)->first();
        return $project;
    }

    public function storeProject(ProjectDTO $projectDTO): Project
    {
        $project = new Project();
        $project->project_name = $projectDTO->getProjectName();
        $project->project_description = $projectDTO->getProjectDescription();
        $project->save();
        return $project;

    }
}
