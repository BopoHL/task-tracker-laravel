<?php

namespace App\DTO;

class ProjectDTO
{
    /**
     * @param string|null $projectName
     * @param string|null $projectDescription
     */
    public function __construct(
        private readonly ?string $projectName,
        private readonly ?string $projectDescription,
    )
    {

    }

    public function getProjectName(): string|null
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
            projectDescription: $data['project_description'],
        );
    }
}
