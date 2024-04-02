<?php

namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserRepository implements IUserRepository
{

    public function getAllUsers(): LengthAwarePaginator
    {
        return DB::table('users')->paginate(50);
    }

    // Поиск User в базе по Id, с возможностью добавить к ответу связанные projects и tasks
    // Search User in base by Id, with opportunity add to response linked projects and tasks
    public function getUserById(int $userId, string|array $relatedTables): User|null
    {
        /** @var User|null $user */
        $user = User::with($relatedTables)->find($userId);
        return $user;
    }

    public function getUserByEmail(string $email, string|array $relatedTables): User|null
    {
        /** @var User|null $user */
        $user = User::with($relatedTables)->where('email', $email)->first();
        return $user;
    }

    public function storeUser(User $user): void
    {
        $user->save();
    }

    public function getAuthUser(): User|Authenticatable|null
    {
        return Auth::user();
    }

    public function getProjectUserByEmail(Project $project, string $email): User|null
    {
        return $project->users()->where('email', $email)->first();
    }
}
