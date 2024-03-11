<?php

namespace App\DTO;

use DateTime;

class TaskDTO
{
    /**
     * @param string $taskName
     * @param string $taskDescription
     * @param string $status
     * @param string $priority
     * @param string|DateTime $deadline
     * @param int $projectId
     * @param int|null $assignerId
     */
    public function __construct(
        private readonly string          $taskName,
        private readonly string          $taskDescription,
        private readonly string          $status,
        private readonly string          $priority,
        private readonly string|DateTime $deadline,
        private readonly int             $projectId,
        private readonly int|null        $assignerId,
    )
    {

    }

    public function getTaskName(): string
    {
        return $this->taskName;
    }

    public function getTaskDescription(): string
    {
        return $this->taskDescription;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * @return DateTime|string
     */
    public function getDeadline(): DateTime|string
    {
        return $this->deadline;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function getAssignerId(): int
    {
        return $this->assignerId;
    }

    public function fromArray(array $data): static
    {
        return new static(
            taskName: $data['task_name'],
            taskDescription: $data['task_description'],
            status: $data['status'],
            priority: $data['priority'],
            deadline: $data['deadline'],
            projectId: $data['project_id'],
            assignerId: $data['assigner_id'],
        );
    }
}
