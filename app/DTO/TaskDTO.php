<?php

namespace App\DTO;

use DateTime;

class TaskDTO
{
    /**
     * @param string|null $taskName
     * @param string|null $taskDescription
     * @param string|null $status
     * @param string|null $priority
     * @param string|DateTime|null $deadline
     * @param string|null $projectId
     * @param string|null $assignerId
     */
    public function __construct(
        private readonly string|null          $taskName,
        private readonly string|null          $taskDescription,
        private readonly string|null          $status,
        private readonly string|null          $priority,
        private readonly string|DateTime|null $deadline,
        private readonly string|null             $projectId,
        private readonly string|null        $assignerId,
    )
    {

    }

    public function getTaskName(): string|null
    {
        return $this->taskName;
    }

    public function getTaskDescription(): string|null
    {
        return $this->taskDescription;
    }

    public function getStatus(): string|null
    {
        return $this->status;
    }

    public function getPriority(): string|null
    {
        return $this->priority;
    }

    /**
     * @return DateTime|string|null
     */
    public function getDeadline(): DateTime|string|null
    {
        return $this->deadline;
    }

    public function getProjectId(): string|null
    {
        return $this->projectId;
    }

    public function getAssignerId(): string|null
    {
        return $this->assignerId;
    }

    public static function fromArray(array $data): static
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
