<?php

namespace App\DTO\Users;

final class LoginUserDTO
{
    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        private readonly string $email,
        private readonly string $password,
    )
    {

    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function fromArray(array $data): LoginUserDTO
    {
        return new LoginUserDTO (
            email: $data['email'],
            password: $data['password']
        );
    }
}
