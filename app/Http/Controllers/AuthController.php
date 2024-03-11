<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    /**
     * @param UserService $service
     */
    public function __construct(private UserService $service)
    {

    }

    /**
     * @throws NotFoundException
     */
    public function confirmEmail(string $token): UserResource
    {
        $email = Cache::get('confirm_token_' . $token);

        if ($email !== null) {
            $user = $this->service->getUserByEmail(email: $email);
            $user->email_verified_at = now();
            $user->save();
            return new UserResource($user);
        } else {
            throw new NotFoundException(__('messages.token_expired'));
        }
    }
}
