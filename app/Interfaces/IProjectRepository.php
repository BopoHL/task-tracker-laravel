<?php

namespace App\Interfaces;

use App\DTO\ProjectDTO;
use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IProjectRepository
{
    public function getProjectById(int $projectId, string|array $relatedTables):
    ?Project;

    public function getProjectByName(string $projectName, string|array
    $relatedTables):
    ?Project;

    public function storeProject(User $user, ProjectDTO $projectDTO): Project;
}
