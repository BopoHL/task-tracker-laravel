<?php

namespace App\DTO\Users;

use DateTime;
use Illuminate\Http\UploadedFile;

final class CreateUserDTO
{
    /**
     * @param string $name
     * @param string $email
     * @param string|DateTime $dateOfBirth
     * @param string $password
     * @param string|null $avatarUrl
     * @param UploadedFile|null $avatar
     */
    public function __construct(
        private readonly string          $name,
        private readonly string          $email,
        private readonly string|DateTime $dateOfBirth,
        private readonly string          $password,
        private readonly string|null          $avatarUrl,
        private readonly UploadedFile|null $avatar,
    )
    {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAvatar(): UploadedFile|null
    {
        return $this->avatar;
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

    public function getAvatarUrl(): string|null
    {
        return $this->avatarUrl;
    }

    public static function fromArray(array $data): CreateUserDTO
    {
        return new CreateUserDTO(
            name: $data['name'],
            email: $data['email'],
            dateOfBirth: $data['date_of_birth'],
            password: $data['password'],
            avatarUrl: $data['avatar_url'] ?? null,
            avatar: $data['avatar'] ?? null,
        );
    }
}
