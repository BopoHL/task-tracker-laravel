<?php

namespace App\DTO\Users;

use DateTime;

class UpdateUserDTO
{
    /**
     * @param string|null $name
     * @param string|DateTime|null $dateOfBirth
     * @param string|null $avatarUrl
     */
    public function __construct(
        private readonly string|null          $name,
        private readonly string|DateTime|null $dateOfBirth,
        private readonly string|null          $avatarUrl,
    )
    {
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDateOfBirth(): DateTime|string|null
    {
        return $this->dateOfBirth;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'] ?? null,
            dateOfBirth: $data['date_of_birth'] ?? null,
            avatarUrl: $data['avatar_url'] ?? null,
        );
    }
}
