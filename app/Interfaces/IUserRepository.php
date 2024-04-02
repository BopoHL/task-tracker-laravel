<?php

namespace App\Interfaces;

use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IUserRepository
{
    public function getAllUsers();

    public function getUserById(int $userId, string|array $relatedTables);

    public function getUserByEmail(string $email, string|array $relatedTables);

    public function storeUser(User $user);

    public function getAuthUser();

    public function getProjectUserByEmail(Project $project, string $email);

}
