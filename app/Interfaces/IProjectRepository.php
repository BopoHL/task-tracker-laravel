<?php

namespace App\Interfaces;

use App\DTO\ProjectDTO;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface IProjectRepository
{
    public function getAllProjects(): Collection;

    public function getProjectById(string $projectId, string|array $relatedTables): ?Project;

    public function getProjectByName(string $projectName, string|array $relatedTables):
    ?Project;

    public function storeProject(ProjectDTO $projectDTO): Project;
}
