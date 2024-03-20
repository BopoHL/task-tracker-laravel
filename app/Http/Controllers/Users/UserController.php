<?php

namespace App\Http\Controllers\Users;

use App\DTO\UserDTO;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
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
     * Store a newly created resource in storage.
     * @throws AlreadyExistException
     */
    public function store(CreateUserRequest $request): UserResource
    {
        $validated = $request->validated();
        $user = $this->service->createUser(UserDTO::fromArray($validated));
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(int $userId): UserResource
    {
        $user = $this->service->getUserById($userId, 'projects.tasks');
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(UpdateUserRequest $request, int $userId): UserResource
    {
        $validated = $request->validated();

        $user = $this->service->updateUser(UserDTO::fromArray($validated), $userId);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(int $userId): JsonResponse
    {
        $result = $this->service->deleteUser($userId);

        return response()->json(['message' => $result]);
    }
}
