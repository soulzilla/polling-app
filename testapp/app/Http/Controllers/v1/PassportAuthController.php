<?php

namespace App\Http\Controllers\v1;

use App\DTO\RegisterUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\UsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class PassportAuthController extends Controller
{
    /**
     * @param UsersService $usersService
     */
    public function __construct(private readonly UsersService $usersService)
    {
    }

    /**
     * Регистрация пользователя по апи
     * /api/v1/register
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $dto = RegisterUserDTO::instance($data);

        if ($token = $this->usersService->register($dto)) {
            return $this->successResponse(['token' => $token]);
        }

        return $this->errorResponse('Cannot create user', 422);
    }

    /**
     * Авторизация пользователя
     * /api/v1/login
     * Для дальнейшей аутентификации выдается токен
     * @param LoginUserRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (auth()->attempt($data)) {
            /** @var string $token */
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return $this->successResponse(['token' => $token]);
        } else {
            return $this->errorResponse('Unauthorized', 401);
        }
    }
}
