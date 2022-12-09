<?php

namespace App\Services;

use App\DTO\RegisterUserDTO;
use App\Repositories\UserRepository;

class UsersService
{
    /**
     * @param UserRepository $repository
     */
    public function __construct(private readonly UserRepository $repository)
    {
    }

    /**
     * Регистрация нового пользователя
     * @param RegisterUserDTO $dto
     * @return string
     */
    public function register(RegisterUserDTO $dto): string
    {
        return $this->repository->register($dto);
    }
}
