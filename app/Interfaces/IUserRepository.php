<?php

namespace App\Interfaces;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface IUserRepository
{
    public function getAllUsers(): Collection;

    public function getUserById(string $userId, string|array $relatedTables): User|null;

    public function getUserByEmail(string $email, string|array $relatedTables): User|null;

    public function storeUser(UserDTO $userDTO): User;
}
