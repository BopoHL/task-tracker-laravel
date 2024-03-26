<?php

namespace App\Services;

use App\DTO\ProjectDTO;
use App\Exceptions\NotFoundException;
use App\Interfaces\IProjectRepository;
use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
    public function getAllUserProjects(int $userId): Collection
    {
        $user = $this->userService->getUserById($userId);

        return $user->projects()->get();
    }

    /**
     * @throws NotFoundException
     */
    public function getUserProjectById(int $userId, int $projectId, string|array $relatedTables =
    []): Project
    {
        $user = $this->userService->getUserById($userId);
        $project = $user->projects()->with($relatedTables)->where('project_id', $projectId)->first();
        if ($project === null) {
            throw new NotFoundException('Project ' . __('messages.with_id_not_found'), 404);
        }
        return $project;
    }

    /**
     * @throws NotFoundException
     */
    public function createProject(ProjectDTO $projectDTO, int $userId): Project
    {
        $user = $this->userService->getUserById($userId);
        return $this->projectRepository->storeProject(user: $user, projectDTO: $projectDTO);
    }

    /**
     * @throws NotFoundException
     */
    public function updateUserProject(ProjectDTO $projectDTO, int $userId, int $projectId): Project
    {
        $project = $this->getUserProjectById(userId: $userId, projectId: $projectId);
        $projectName = $projectDTO->getProjectName();
        $projectDescription = $projectDTO->getProjectDescription();

        if ($projectName !== null) {
            $project->project_name = $projectName;
        }

        if ($projectDescription !== null) {
            $project->project_description = $projectDescription;
        }

        $project->save();
        return $project;
    }

    /**
     * @throws NotFoundException
     */
    public function deleteUserProject(int $userId, int $projectId): string
    {
        $project = $this->getUserProjectById(
            userId: $userId,
            projectId: $projectId
        );

        $project->delete();
        return __('messages.delete_successful');
    }
}
