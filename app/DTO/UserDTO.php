<?php

namespace App\DTO;

use DateTime;

class UserDTO
{
    /**
     * @param string $name
     * @param string $email
     * @param string|DateTime $dateOfBirth
     * @param string $password
     * @param string $avatarUrl
     */
    public function __construct(
        private readonly string          $name,
        private readonly string          $email,
        private readonly string|DateTime $dateOfBirth,
        private readonly string          $password,
        private readonly string          $avatarUrl,
    )
    {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|DateTime
     */
    public function getDateOfBirth(): string|DateTime
    {
        return $this->dateOfBirth;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAvatarUrl(): string
    {
        return $this->avatarUrl;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'],
            email: $data['email'],
            dateOfBirth: $data['date_of_birth'],
            password: $data['password'],
            avatarUrl: $data['avatar_url'],
        );
    }
}
