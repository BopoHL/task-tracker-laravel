<?php

namespace App\DTO\Tasks;

use DateTime;

final class TaskDTO
{
    /**
     * @param string $taskName
     * @param string|null $taskDescription
     * @param string|null $status
     * @param string|null $priority
     * @param string|DateTime|null $deadline
     * @param int|null $assignerId
     */
    public function __construct(
        private readonly string         $taskName,
        private readonly string|null          $taskDescription,
        private readonly string|null          $status,
        private readonly string|null          $priority,
        private readonly string|DateTime|null $deadline,
        private readonly int|null        $assignerId,
    )
    {

    }

    public function getTaskName(): string
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

    public function getAssignerId(): int|null
    {
        return $this->assignerId;
    }

    public static function fromArray(array $data): TaskDTO
    {
        return new TaskDTO(
            taskName: $data['task_name'],
            taskDescription: $data['task_description'] ?? null,
            status: $data['status'] ?? 'not_started',
            priority: $data['priority'] ?? null,
            deadline: $data['deadline'] ?? null,
            assignerId: $data['assigner_id'] ?? null,
        );
    }
}
