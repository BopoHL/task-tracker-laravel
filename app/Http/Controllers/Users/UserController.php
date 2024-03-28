<?php

namespace App\Http\Controllers\Users;

use App\DTO\Users\UpdateUserDTO;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\Users\UserResource;
use App\Services\UserService;

class UserController extends Controller
{

    /**
     * @param UserService $service
     */
    public function __construct(private readonly UserService $service)
    {
    }

    /**
     * Display the specified resource.
     * @throws NotFoundException
     */
    public function me(): UserResource
    {
        $user = $this->service->getAuthUser();
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     * @throws NotFoundException
     */
    public function updateMe(UpdateUserRequest $request): UserResource
    {
        $validated = $request->validated();

        $user = $this->service->updateUser(
            userDTO: UpdateUserDTO::fromArray($validated),
        );

        return new UserResource($user);
    }

}
