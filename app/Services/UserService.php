<?php

namespace App\Services;

use App\DTO\Users\UpdateUserDTO;
use App\DTO\Users\CreateUserDTO;
use App\Exceptions\NotFoundException;
use App\Interfaces\IUserRepository;
use App\Models\User;

class UserService
{
    /**
     * @param IUserRepository $repository
     */
    public function __construct(private readonly IUserRepository $repository)
    {
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
    public function updateUser(UpdateUserDTO $userDTO): User
    {
        $user = $this->getAuthUser();

        $name = $userDTO->getName();
        $avatarUrl = $userDTO->getAvatarUrl();
        $dateOfBirth = $userDTO->getDateOfBirth();

        if ($name !== null) {
            $user->name = $name;
        }
        if ($avatarUrl !== null) {
            $user->avatar_url = $avatarUrl;
        }
        if ($dateOfBirth !== null) {
            $user->date_of_birth = $dateOfBirth;
        }

        $this->repository->storeUser($user);
        return $user;
    }

    /**
     * @throws NotFoundException
     */
    public function getAuthUser(): User
    {
        $user = $this->repository->getAuthUser();

        if ($user === null) {
            throw new NotFoundException('messages.not_login');
        }

        return $user;
    }

}
