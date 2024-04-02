<?php

namespace App\Services;

use App\DTO\Tasks\TaskDTO;
use App\Exceptions\NotFoundException;
use App\Interfaces\ITaskRepository;
use App\Interfaces\IUserRepository;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskService
{
    /**
     * @param ITaskRepository $taskRepository
     * @param IUserRepository $userRepository
     * @param ProjectService $projectService
     */
    public function __construct(
        private readonly ITaskRepository $taskRepository,
        private readonly IUserRepository $userRepository,
        private readonly ProjectService  $projectService,
    )
    {
    }

    /**
     * @throws NotFoundException
     */
    public function getAllProjectTasks($projectId): Collection
    {
        $project = $this->projectService->getUserProjectById($projectId);

        return $this->taskRepository->getAllProjectTasks($project);
    }

    /**
     * @throws NotFoundException
     */
    public function getProjectTaskById(int $projectId, int $taskId): Task
    {
        $project = $this->projectService->getUserProjectById($projectId);
        $task = $this->taskRepository->getProjectTaskById($project, $taskId);
        if ($task === null) {
            throw new NotFoundException('Task ' . __('messages.with_id_not_found'), 404);
        }
        return $task;
    }

    /**
     * @throws NotFoundException
     */
    public function createTask(TaskDTO $taskDTO, int $projectId): Task
    {

        $project = $this->projectService->getUserProjectById($projectId);

        $task = new Task();
        $task->task_name = $taskDTO->getTaskName();
        $task->task_description = $taskDTO->getTaskDescription();
        $task->status = $taskDTO->getStatus();
        $task->priority = $taskDTO->getPriority();
        $task->deadline = $taskDTO->getDeadline();
        $task->assigner_id = $taskDTO->getAssignerId();
        $task->project_id = $project->id;

        $this->taskRepository->storeTask($task);
        return $task;
    }

    /**
     * @throws NotFoundException
     */
    public function updateProjectTask(TaskDTO $taskDTO, int $projectId, int $taskId): Task
    {
        $task = $this->getProjectTaskById(
            projectId: $projectId, taskId: $taskId
        );

        $taskName = $taskDTO->getTaskName();
        $taskDescription = $taskDTO->getTaskDescription();
        $taskAssigner = $taskDTO->getAssignerId();
        $taskDeadline = $taskDTO->getDeadline();
        $taskStatus = $taskDTO->getStatus();
        $taskPriority = $taskDTO->getPriority();

        $task->task_name = $taskName;

        if ($taskDescription !== null) {
            $task->task_description = $taskDescription;
        }
        if ($taskAssigner !== null) {
            $task->assigner_id = $taskAssigner;
        }
        if ($taskDeadline !== null) {
            $task->deadline = $taskDeadline;
        }
        if ($taskStatus !== null) {
            $task->status = $taskStatus;
        }
        if ($taskPriority !== null) {
            $task->priority = $taskPriority;
        }

        $this->taskRepository->storeTask($task);

        return $task;
    }

    /**
     * @throws NotFoundException
     */
    public function deleteProjectTask(int $projectId, int $taskId): string
    {
        $task = $this->getProjectTaskById($projectId, $taskId);

        $this->taskRepository->deleteTask($task);
        return __('messages.delete_successful');
    }

    /**
     * @throws NotFoundException
     */
    public function addAssigner(int $projectId, int $taskId, string $email): User
    {
        $project = $this->projectService->getUserProjectById($projectId);

        $user = $this->userRepository->getProjectUserByEmail($project, $email);

        if ($user === null) {
            throw new NotFoundException('User' . __('messages.with_email_not_found'));
        }

        $task = $this->getProjectTaskById($projectId, $taskId);

        $task->assigner_id = $user->id;

        $this->taskRepository->storeTask($task);

        return $task->assigner()->first();
    }
}


