<?php

namespace App\DTO\Projects;

class ProjectDTO
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

    public static function fromArray(array $data): static
    {
        return new static(
            projectName: $data['project_name'],
            projectDescription: $data['project_description'] ?? null,
        );
    }
}
