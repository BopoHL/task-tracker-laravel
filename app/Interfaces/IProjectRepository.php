<?php

namespace App\Interfaces;

use App\DTO\Projects\ProjectDTO;
use App\Models\Project;
use App\Models\User;

interface IProjectRepository
{
    public function getProjectById(int $projectId, string|array $relatedTables);

    public function getProjectByName(string $projectName, string|array $relatedTables);

    public function storeProject(Project $project);

    public function destroyProject(Project $project);
}
