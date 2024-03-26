<?php

namespace App\Http\Controllers\Users;

use App\DTO\UserDTO;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\RegisterRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\Users\UserCollection;
use App\Http\Resources\Users\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    /**
     * @param UserService $service
     */
    public function __construct(private readonly UserService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): UserCollection
    {
        $users = $this->service->getAllUsers();
        return new UserCollection($users);
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(int $userId): UserResource
    {
        $user = $this->service->getUserById(
            userId: $userId,
            relatedTables: 'projects.tasks',
        );
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(UpdateUserRequest $request, int $userId): UserResource
    {
        $validated = $request->validated();

        $user = $this->service->updateUser(
            userDTO: UserDTO::fromArray($validated),
            userId: $userId,
        );

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(int $userId): JsonResponse
    {
        $result = $this->service->deleteUser(userId: $userId);

        return response()->json(['message' => $result]);
    }
}
