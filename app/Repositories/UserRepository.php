<?php

namespace App\Repositories;

use App\DTO\UserDTO;
use App\Interfaces\IUserRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Return_;
use function PHPUnit\Framework\isNull;

class UserRepository implements IUserRepository
{

    public function getAllUsers(): Collection
    {
        return User::all();
    }

    // Поиск User в базе по Id, с возможностью добавить к ответу связанные projects и tasks
    // Search User in base by Id, with opportunity add to response linked projects and tasks
    public function getUserById(string $userId, string|array $relatedTables): User|null
    {
        /** @var User|null $user */
        $user = User::with($relatedTables)->find($userId);
        return $user;
    }

    public function getUserByEmail(string $email, string|array $relatedTables): ?User
    {
        /** @var User|null $user */
        $user = User::with($relatedTables)->where('email', $email)->first();
        return $user;
    }

    public function storeUser(UserDTO $userDTO): User
    {
        $user = new User();
        $user->name = $userDTO->getName();
        $user->email = $userDTO->getEmail();
        $user->password = bcrypt($userDTO->getPassword());
        $user->date_of_birth = $userDTO->getDateOfBirth();
        $user->avatar_url = $userDTO->getAvatarUrl();

        $user->save();

        return $user;
    }
}
