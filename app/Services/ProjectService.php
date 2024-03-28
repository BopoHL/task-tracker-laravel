<?php

namespace App\Services;

use App\DTO\Projects\ProjectDTO;
use App\Exceptions\InvalidOperationException;
use App\Exceptions\NotFoundException;
use App\Interfaces\IProjectRepository;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    /**
     * @param IProjectRepository $projectRepository
     * @param UserService $userService
     */
    public function __construct(
        private readonly IProjectRepository $projectRepository,
        private readonly UserService        $userService,
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function getAllUserProjects(): Collection
    {
        $user = $this->userService->getAuthUser();

        return $user->projects()->get();
    }

    /**
     * @throws NotFoundException
     */
    public function getUserProjectById(
        int          $projectId,
        string|array $relatedTables = []
    ): Project
    {
        $user = $this->userService->getAuthUser();
        $project = $user->projects()->with($relatedTables)->where('project_id', $projectId)->first();
        if ($project === null) {
            throw new NotFoundException('Project ' . __('messages.with_id_not_found'), 404);
        }
        return $project;
    }

    /**
     * @throws NotFoundException
     */
    public function createProject(ProjectDTO $projectDTO): Project
    {
        $user = $this->userService->getAuthUser();

        $project = new Project();
        $project->project_name = $projectDTO->getProjectName();
        $project->project_description = $projectDTO->getProjectDescription();

        $this->projectRepository->storeProject($project);
        $project->users()->attach($user, ['role' => 'owner']);

        return $project;
    }

    /**
     * @throws NotFoundException
     */
    public function updateUserProject(ProjectDTO $projectDTO, int $projectId): Project
    {
        $project = $this->getUserProjectById(projectId: $projectId);
        $projectName = $projectDTO->getProjectName();
        $projectDescription = $projectDTO->getProjectDescription();

        $project->project_name = $projectName;

        if ($projectDescription !== null) {
            $project->project_description = $projectDescription;
        }

        $this->projectRepository->storeProject($project);
        return $project;
    }

    /**
     * @throws InvalidOperationException
     * @throws NotFoundException
     */
    public function addUserToProject(
        string $userEmail, string $role, int $projectId
    ): Collection
    {
        $project = $this->getUserProjectById(projectId: $projectId);
        $authUser = $this->userService->getAuthUser();
        $newUser = $this->userService->getUserByEmail(email: $userEmail);

        $allowedRoles = ['owner', 'manager'];

        if (
            $authUser->projects()
            ->where('project_id', $projectId)
            ->wherePivotIn('role', $allowedRoles)
            ->exists()
        ) {
            $project->users()->attach($newUser, ['role' => $role]);
            return $project->users()->withPivot('role')->get();
        } else {
            throw new InvalidOperationException(__('messages.invalid_operation'), 403);
        }
    }

    /**
     * @throws NotFoundException
     */
    public function deleteUserProject(int $projectId): string
    {
        $project = $this->getUserProjectById(
            projectId: $projectId
        );

        $this->projectRepository->destroyProject($project);
        return __('messages.delete_successful');
    }
}
