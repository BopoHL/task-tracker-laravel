<?php

namespace App\Interfaces;

use App\DTO\Projects\ProjectDTO;
use App\Models\Project;
use App\Models\User;

interface IProjectRepository
{
    public function getProjectById(int $projectId, string|array $relatedTables):
    ?Project;

    public function getProjectByName(string $projectName, string|array
    $relatedTables):
    ?Project;

    public function storeProject(Project $project): void;

    public function destroyProject(Project $project): void;
}
