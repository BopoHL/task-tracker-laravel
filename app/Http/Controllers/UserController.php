<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @param UserService $service
     */
    public function __construct(private UserService $service)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return $this->service->getAllUsers();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $userId): ?User
    {
        $user = $this->service->getUserById($userId, 'projects.tasks');
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
