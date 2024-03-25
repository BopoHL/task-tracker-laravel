<?php

namespace App\Services;


use App\Exceptions\InvalidOperationException;
use App\Exceptions\NotFoundException;
use App\Models\Project;

class AddUserToTaskService
{
    /**
     * @param UserService $userService
     * @param ProjectService $projectService
     * @param TaskService $taskService
     */
    public function __construct(
        private readonly UserService    $userService,
        private readonly ProjectService $projectService,
        private readonly TaskService $taskService
    )
    {

    }

    /**
     * @throws NotFoundException
     * @throws InvalidOperationException
     */
    public function addUserToTask(int $userId, string $userEmail, string $role, int $projectId, int
    $taskId):
    \Illuminate\Database\Eloquent\Collection
    {
        $user = $this->userService->getUserByEmail($userEmail);
        $task = $this->taskService->getUserTaskById(userId: $userId, projectId: $projectId, taskId: $taskId);

        $userRole = $task->users()->where('user_id', $userId)->value('role');

        if ($userRole == 'owner' || $userRole == 'manager' || $userRole == 'contributor') {
            $task->users()->attach($user, ['role' => $role]);
            return $task->users()->withPivot('role')->get();
        } else {
            throw new InvalidOperationException(__('messages.invalid_operation'));
        }
    }
}
