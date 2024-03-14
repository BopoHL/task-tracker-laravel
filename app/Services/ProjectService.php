<?php

namespace App\Services;

use App\DTO\ProjectDTO;
use App\Exceptions\NotFoundException;
use App\Interfaces\IProjectRepository;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    public function __construct(private readonly IProjectRepository $repository)
    {

    }

    public function getAllProjects(): Collection
    {
        return $this->repository->getAllProjects();
    }

    /**
     * @throws NotFoundException
     */
    public function getProjectById(string $projectId, string|array $relatedTables = []): Project
    {
        $project = $this->repository->getProjectById($projectId, $relatedTables);
        if ($project === null) {
            throw new NotFoundException('Project' . __('messages.with_id_not_found'));
        }

        return $project;
    }

    /**
     * @throws NotFoundException
     */
    public function getProjectByName(string $projectName, string|array $relatedTables = []): Project
    {
        $project = $this->repository->getProjectByName($projectName, $relatedTables);
        if ($project === null) {
            throw new NotFoundException('Project' . __('messages.with_name_not_found'));
        }
        return $project;
    }

    public function createProject(ProjectDTO $projectDTO): Project
    {
        return $this->repository->storeProject($projectDTO);
    }

    /**
     * @throws NotFoundException
     */
    public function updateProject(ProjectDTO $projectDTO, string $projectId): Project
    {
        $project = $this->getProjectById($projectId);
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
    public function deleteProject(string $projectId): string
    {
        $project = $this->getProjectById($projectId);

        $project->delete();
        return __('messages.delete_successful');
    }
}
