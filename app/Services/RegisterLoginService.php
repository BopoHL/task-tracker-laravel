<?php

namespace App\Services;

use App\DTO\Users\LoginUserDTO;
use App\DTO\Users\CreateUserDTO;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\InvalidOperationException;
use App\Exceptions\NotFoundException;
use App\Interfaces\IUserRepository;
use App\Jobs\SendConfirmEmail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class RegisterLoginService
{
    public function __construct(
        private readonly IUserRepository $userRepository,
    )
    {
    }

    /**
     * @throws AlreadyExistException
     */
    public function registerUser(CreateUserDTO $userDTO): JsonResponse
    {
        $userEmail = $userDTO->getEmail();
        $user = $this->userRepository->getUserByEmail(email: $userEmail, relatedTables: []);

        if ($user !== null) {
            throw new AlreadyExistException('User ' . __('messages.with_email_already_exist'), 400);
        } else {
            // Creating confirmation token and saving it into Cache.
            $confirmationToken = Str::uuid();
            Cache::put('confirm_token_' . $confirmationToken, $userEmail, 600);
            // Creating confirmation link
            $confirmationLink = route('confirm-email', ['token' => $confirmationToken]);
            // Send confirmation link with token on email
            dispatch(new SendConfirmEmail($userEmail, $confirmationLink));

            // Save user to database, without email_verified_at field
            $user = new User();
            $user->name = $userDTO->getName();
            $user->email = $userDTO->getEmail();
            $user->password = bcrypt($userDTO->getPassword());
            $user->date_of_birth = $userDTO->getDateOfBirth();
            $user->avatar_url = $userDTO->getAvatarUrl();
            $this->userRepository->storeUser($user);

            return response()->json(['message' => __('messages.register_success')]);
        }
    }

    /**
     * @throws NotFoundException
     */
    public function confirmUserEmail(string $token): JsonResponse
    {
        $email = Cache::get('confirm_token_' . $token);

        if ($email !== null) {
            $user = $this->userRepository->getUserByEmail(email: $email, relatedTables: []);
            $user->email_verified_at = now();
            $this->userRepository->storeUser($user);

            return response()->json(['message' => __('messages.email_confirmation_success')]);
        } else {
            throw new NotFoundException(__('messages.token_expired'));
        }
    }

    /**
     * @throws InvalidOperationException
     */
    public function login(LoginUserDTO $loginDTO): JsonResponse
    {
        $email = $loginDTO->getEmail();
        $password = $loginDTO->getPassword();
        if (Auth::validate([
            'email' => $email,
            'password' => $password,
        ])) {
            $user = Auth::getLastAttempted();
            if ($user->email_verified_at !== null) {
                Auth::login($user);
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json(['token' => $token]);
            } else {
                throw new InvalidOperationException(__('messages.email_not_confirmed'), 403);
            }
        } else {
            throw new InvalidOperationException(__('messages.login_failed'), 401);
        }
    }

    /**
     * @throws InvalidOperationException
     */
    public function logout(): JsonResponse
    {
        if (\auth()->check()) {
            Auth::user()->tokens()->delete();
            return response()->json(['message' => __('messages.logout_complete')], 200);
        } else {
            throw new InvalidOperationException(__('messages.not_login'), 403);
        }
    }
}
