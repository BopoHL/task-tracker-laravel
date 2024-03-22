<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\InvalidOperationException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    /**
     * @throws InvalidOperationException
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if (Auth::validate([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
            $user = Auth::getLastAttempted();
            if ($user->email_verified_at !== null) {
                Auth::login($user);
                $token = $user->createToken('auth_token')->plainTextToken;
                cache(['user' . $validated['email'] . ':token' => $token], now()->addHours(24));

                return response()->json(['token' => $token]);
            } else {
                throw new InvalidOperationException(__('messages.email_not_confirmed'));
            }
        }
    }

    /**
     * @throws InvalidOperationException
     */
    public function logout(): JsonResponse
    {
        if (auth()->check()) {
            Auth::user()->tokens()->delete();
            return response()->json(['message' => __('messages.logout_complete')], 200);
        } else {
            throw new InvalidOperationException(__('messages.not_login'));
        }
    }
}
