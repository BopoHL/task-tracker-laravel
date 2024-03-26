<?php

namespace App\Interfaces;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IUserRepository
{
    public function getAllUsers(): LengthAwarePaginator;

    public function getUserById(int $userId, string|array $relatedTables): User|null;

    public function getUserByEmail(string $email, string|array $relatedTables): User|null;

    public function storeUser(User $user): void;
}
