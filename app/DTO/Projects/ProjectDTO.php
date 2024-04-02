<?php

namespace App\DTO\Projects;

final class ProjectDTO
{
    /**
     * @param string $projectName
     * @param string|null $projectDescription
     */
    public function __construct(
        private readonly string $projectName,
        private readonly string|null $projectDescription,
    )
    {

    }

    public function getProjectName(): string
    {
        return $this->projectName;
    }

    public function getProjectDescription(): string|null
    {
        return $this->projectDescription;
    }

    public static function fromArray(array $data): ProjectDTO
    {
        return new ProjectDTO(
            projectName: $data['project_name'],
            projectDescription: $data['project_description'] ?? null,
        );
    }
}
