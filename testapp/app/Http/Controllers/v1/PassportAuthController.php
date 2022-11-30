<?php

namespace App\Http\Controllers\v1;

use App\DTO\RegisterUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\UsersService;
use Illuminate\Http\JsonResponse;

class PassportAuthController extends Controller
{
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
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Cannot create user'], 422);
    }

    /**
     * Авторизация пользователя
     * /api/v1/login
     * Для дальнейшей аутентификации выдается токен
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (auth()->attempt($data)) {
            /** @var string $token */
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
