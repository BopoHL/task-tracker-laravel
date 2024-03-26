<?php

namespace App\Http\Controllers\RegisterLogin;

use App\DTO\LoginDTO;
use App\DTO\UserDTO;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\InvalidOperationException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Http\Resources\Users\UserResource;
use App\Services\RegisterLoginService;
use Illuminate\Http\JsonResponse;

class RegisterLoginController extends Controller
{
    /**
     * @param RegisterLoginService $registerLoginService
     */
    public function __construct(
        private readonly RegisterLoginService $registerLoginService,
    )
    {
    }

    /**
     * @throws AlreadyExistException
     */
    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        $validated = $registerRequest->validated();
        return $this->registerLoginService->registerUser(UserDTO::fromArray($validated));
    }

    /**
     * @throws NotFoundException
     */
    public function confirmUserEmail(string $token): JsonResponse
    {
        return $this->registerLoginService->confirmUserEmail($token);
    }

    /**
     * @throws InvalidOperationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        return $this->registerLoginService->login(LoginDTO::fromArray($validated));
    }

    /**
     * @throws InvalidOperationException
     */
    public function logout(): JsonResponse
    {
        return $this->registerLoginService->logout();
    }
}
