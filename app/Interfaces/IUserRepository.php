<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IUserRepository
{
    public function getAllUsers(): LengthAwarePaginator;

    public function getUserById(int $userId, string|array $relatedTables): User|null;

    public function getUserByEmail(string $email, string|array $relatedTables): User|null;

    public function storeUser(User $user): void;

    public function getAuthUser(): User|Authenticatable|null;
}
