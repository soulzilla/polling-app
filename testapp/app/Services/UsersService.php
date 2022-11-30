<?php

namespace App\Services;

use App\DTO\RegisterUserDTO;
use App\Models\User;

class UsersService
{
    /**
     * Регистрация нового пользователя
     * @param RegisterUserDTO $dto
     * @return string
     */
    public function register(RegisterUserDTO $dto): string
    {
        /** @var User $user */
        $user = User::query()->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => bcrypt($dto->password)
        ]);

        return $user->createToken('LaravelAuthApp')->accessToken;
    }
}
