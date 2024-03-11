<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\NotFoundException;
use App\Interfaces\IUserRepository;
use App\Jobs\SendConfirmEmail;
use App\Models\User;
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

    public function getAllUsers(): Collection
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
            throw new NotFoundException(__('messages.user_with_id_not_found'));
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
            throw new NotFoundException(__('messages.user_with_email_not_found'));
        }

        return $user;
    }

    /**
     * @throws AlreadyExistException
     */
    public function createUser(UserDTO $userDTO): User
    {
        $userEmail = $userDTO->getEmail();
        $userWithEmail = $this->repository->getUserByEmail(email: $userEmail);

        // Check for existence user with such email
        if ($userWithEmail !== null) {
            throw new AlreadyExistException(__('messages.user_with_email_already_exist'));
        }

        // Creating confirmation token and saving it into Cache.
        $confirmationToken = Str::uuid();
        Cache::put('confirm_token_' . $confirmationToken, $userEmail, 600);
        // Creating confirmation link
        $confirmationLink = route('confirm-email', ['token' => $confirmationToken]);
        // Send confirmation link with token on email
        dispatch(new SendConfirmEmail($userEmail, $confirmationLink));

        // Save user to database, without email_verified_at field
        return $this->repository->storeUser($userDTO);
    }
}
