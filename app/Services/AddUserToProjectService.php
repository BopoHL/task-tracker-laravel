<?php

namespace App\Services;


use App\Exceptions\NotFoundException;
use App\Models\Project;

class AddUserToProjectService
{
    /**
     * @param UserService $userService
     * @param ProjectService $projectService
     */
    public function __construct(
        private readonly UserService    $userService,
        private readonly ProjectService $projectService
    )
    {

    }

    /**
     * @throws NotFoundException
     */
    public function addUserToProject(string $userEmail, string $role, string $projectId): Project
    {
        $user = $this->userService->getUserByEmail($userEmail);
        $project = $this->projectService->getProjectById($projectId);

        $project->users()->attach($user, ['role' => $role]);
        return $project;
    }
}
