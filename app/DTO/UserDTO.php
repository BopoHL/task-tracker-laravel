<?php

namespace App\DTO;

use DateTime;

class UserDTO
{
    /**
     * @param string|null $name
     * @param string|null $email
     * @param string|DateTime|null $dateOfBirth
     * @param string|null $password
     * @param string|null $avatarUrl
     */
    public function __construct(
        private readonly string|null          $name,
        private readonly string|null          $email,
        private readonly string|DateTime|null $dateOfBirth,
        private readonly string|null          $password,
        private readonly string|null          $avatarUrl,
    )
    {

    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function getEmail(): string|null
    {
        return $this->email;
    }

    /**
     * @return string|DateTime|null
     */
    public function getDateOfBirth(): string|DateTime|null
    {
        return $this->dateOfBirth;
    }

    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function getAvatarUrl(): string|null
    {
        return $this->avatarUrl;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            dateOfBirth: $data['date_of_birth'] ?? null,
            password: $data['password'] ?? null,
            avatarUrl: $data['avatar_url'] ?? null,
        );
    }
}
