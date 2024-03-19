<?php

namespace App\Interfaces;

use App\DTO\ProjectDTO;
use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IProjectRepository
{
    public function getAllProjects(): LengthAwarePaginator;

    public function getProjectById(string $projectId, string|array $relatedTables): ?Project;

    public function getProjectByName(string $projectName, string|array $relatedTables):
    ?Project;

    public function storeProject(ProjectDTO $projectDTO): Project;
}
