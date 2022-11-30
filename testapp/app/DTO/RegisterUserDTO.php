<?php
namespace App\DTO;

/**
 * Data Transfer Object для регистрации пользователя
 */
class RegisterUserDTO
{
    public string $name;
    public string $email;
    public string $password;

    /**
     * @param array<string, mixed> $data
     * @return RegisterUserDTO
     */
    public static function instance(array $data): RegisterUserDTO
    {
        $dto = new self();
        $dto->name = $data['name'] ?? '';
        $dto->email = $data['email'] ?? '';
        $dto->password = $data['password'] ?? '';

        return $dto;
    }
}
