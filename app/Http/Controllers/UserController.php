<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
    public function store(CreateUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = $this->service->createUser(UserDTO::fromArray($validated));
        return response()->json(new UserResource($user));
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function show(string $userId): JsonResponse
    {
        $user = $this->service->getUserById($userId, 'projects.tasks');
        return response()->json(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function update(UpdateUserRequest $request, string $userId): UserResource
    {
        $validated = $request->validated();

        $user = $this->service->updateUser(UserDTO::fromArray($validated), $userId);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     * @throws NotFoundException
     */
    public function destroy(string $userId): JsonResponse
    {
        $result = $this->service->deleteUser($userId);

        return response()->json(['message' => $result]);
    }
}