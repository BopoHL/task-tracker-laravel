<?php

namespace App\Services;

use App\DTO\Tasks\TaskDTO;
use App\Exceptions\NotFoundException;
use App\Interfaces\ITaskRepository;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    /**
     * @param ITaskRepository $taskRepository
     * @param UserService $userService
     */
    public function __construct(
        private readonly ITaskRepository $taskRepository,
        private readonly UserService        $userService,
    )
    {
    }

//    public function getAllTasks(): LengthAwarePaginator
//    {
//        return $this->taskService->getAllTasks();
//    }
//
//    /**
//     * @throws NotFoundException
//     */
//    public function getTaskById(int $taskId, string|array $relatedTables = []): Task
//    {
//        $task = $this->taskService->getTaskById($taskId, $relatedTables);
//        if ($task === null) {
//            throw new NotFoundException('Task ' . __('messages.with_id_not_found'));
//        }
//
//        return $task;
//    }
//
//    /**
//     * @throws NotFoundException
//     */
//    public function getTaskByName(string $taskName, string|array $relatedTables = []): Task
//    {
//        $task = $this->taskService->getTaskByName($taskName, $relatedTables);
//        if ($task === null) {
//            throw new NotFoundException('Task ' . __('messages.with_name_not_found'));
//        }
//        return $task;
//    }
//
////    public function createTask(TaskDTO $taskDTO): Task
////    {
////        return $this->repository->storeTask($taskDTO);
////    }
//    public function createTask(TaskDTO $taskDTO, int $userId): Task
//    {
//        $user = $this->userService->getUserById($userId);
//        return $this->taskRepository->storeTask(user: $user, taskDTO: $taskDTO);
//    }
//    /**
//     * @throws NotFoundException
//     */
//    public function updateTask(TaskDTO $taskDTO, int $taskId): Task
//    {
//        $task = $this->getTaskById($taskId);
//        $taskName = $taskDTO->getTaskName();
//        $taskDescription = $taskDTO->getTaskDescription();
//
//        if ($taskName !== null) {
//            $task->task_name = $taskName;
//        }
//
//        if ($taskDescription !== null) {
//            $task->task_description = $taskDescription;
//        }
//
//        $task->save();
//        return $task;
//    }
//
//    /**
//     * @throws NotFoundException
//     */
//    public function deleteTask(int $taskId): string
//    {
//        $task = $this->getTaskById($taskId);
//
//        $task->delete();
//        return __('messages.delete_successful');
//    }
    public function getAllUserTasks(int $userId): Collection
    {
        $user = $this->userService->getUserById($userId);

        return $user->tasks()->get();
    }

    /**
     * @throws NotFoundException
     */
    public function getUserTaskById(int $userId, int $projectId, int $taskId, string|array $relatedTables =
    []): object
    {
        $user = $this->userService->getUserById($userId);
        $task = $user->tasks()->where('id', $taskId)->first();
        if ($task === null) {
            throw new NotFoundException('Task ' . __('messages.with_id_not_found'), 404);
        }
        return $task;
    }

    /**
     * @throws NotFoundException
     */
    public function createTask(TaskDTO $taskDTO, int $userId): Task
    {
        $user = $this->userService->getUserById($userId);
        return $this->taskRepository->storeTask(user: $user, taskDTO: $taskDTO);
    }

    /**
     * @throws NotFoundException
     */
    public function updateUserTask(TaskDTO $taskDTO, int $userId, int $projectId, int $taskId): Task
    {
        $task = $this->getUserTaskById(userId: $userId, projectId: $projectId, taskId: $taskId);
        $taskName = $taskDTO->getTaskName();
        $taskDescription = $taskDTO->getTaskDescription();

        if ($taskName !== null) {
            $task->task_name = $taskName;
        }

        if ($taskDescription !== null) {
            $task->task_description = $taskDescription;
        }

        $task->save();
        return $task;
    }

    /**
     * @throws NotFoundException
     */
    public function deleteUserTask(int $userId, int $projectId, int $taskId): string
    {
        $task = $this->getUserTaskById(
            userId: $userId,
            projectId: $projectId,
            taskId: $taskId
        );

        $task->delete();
        return __('messages.delete_successful');
    }
    public function addUserToTask()
    {

    }
}


