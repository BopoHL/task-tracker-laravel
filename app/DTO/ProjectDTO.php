<?php

namespace App\DTO;

class ProjectDTO
{
    /**
     * @param string $projectName
     * @param string $projectDescription
     */
    public function __construct(
        private readonly string $projectName,
        private readonly string $projectDescription,
    )
    {

    }

    public function getProjectName(): string
    {
        return $this->projectName;
    }

    public function getProjectDescription(): string
    {
        return $this->projectDescription;
    }

    public function fromArray(array $data): static
    {
        return new static(
            projectName: $data['project_name'],
            projectDescription: $data['project_description'],
        );
    }
}
