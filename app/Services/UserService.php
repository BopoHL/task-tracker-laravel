<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\NotFoundException;
use App\Interfaces\IUserRepository;
use App\Jobs\SendConfirmEmail;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class UserService
{
    /**
     * @param IUserRepository $repository
     */
    public function __construct(private readonly IUserRepository $repository)
    {
    }

    public function getAllUsers(): LengthAwarePaginator
    {
        return $this->repository->getAllUsers();
    }

    /**
     * @throws NotFoundException
     */
    public function getUserById(int $userId, string|array $relatedTables = []): ?User
    {
        $user = $this->repository->getUserById($userId, $relatedTables);
        if ($user === null) {
            throw new NotFoundException('User ' . __('messages.with_id_not_found'), 404);
        }

        return $user;
    }

    /**
     * @throws NotFoundException
     */
    public function getUserByEmail(string $email, string|array $relatedTables = []): User
    {
        $user = $this->repository->getUserByEmail($email, $relatedTables);

        if ($user === null) {
            throw new NotFoundException('User ' . __('messages.with_email_not_found'), 404);
        }

        return $user;
    }

    /**
     * @throws NotFoundException
     */
    public function updateUser(UserDTO $userDTO, int $userId): User
    {
        $user = $this->getUserById($userId);

        $email = $userDTO->getEmail();
        $name = $userDTO->getName();
        $avatarUrl = $userDTO->getAvatarUrl();
        $dateOfBirth = $userDTO->getDateOfBirth();
        $password = $userDTO->getPassword();

        if ($email !== null) {
            $user->email = $email;
        }
        if ($name !== null) {
            $user->name = $name;
        }
        if ($avatarUrl !== null) {
            $user->avatar_url = $avatarUrl;
        }
        if ($dateOfBirth !== null) {
            $user->date_of_birth = $dateOfBirth;
        }
        if ($password !== null) {
            $user->password = $password;
        }

        $user->save();
        return $user;
    }

    /**
     * @throws NotFoundException
     */
    public function deleteUser(int $userId): string
    {
        $user = $this->getUserById($userId);

        $user->delete();
        return __('messages.delete_successful');
    }
}
