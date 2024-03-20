<?php

namespace App\Services;


use App\Exceptions\InvalidOperationException;
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
     * @throws InvalidOperationException
     */
    public function addUserToProject(int $managerId, string $userEmail, string $role, int
    $projectId):
    \Illuminate\Database\Eloquent\Collection
    {
        $user = $this->userService->getUserByEmail($userEmail);
        $project = $this->projectService->getUserProjectById(userId: $managerId, projectId: $projectId);

        $managerRole = $project->users()->where('user_id', $managerId)->value('role');

        if ($managerRole == 'owner' || $managerRole == 'manager') {
            $project->users()->attach($user, ['role' => $role]);
            return $project->users()->withPivot('role')->get();
        } else {
            throw new InvalidOperationException(__('messages.invalid_operation'));
        }
    }
}
