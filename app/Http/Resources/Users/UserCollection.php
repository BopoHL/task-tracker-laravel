<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'users' => $this->collection->map(function ($user) {
                return [
                    'name' => $user->name,
                    'email' => $user->email,
                    'date_of_birth' => $user->date_of_birth,
                    'avatar_url' => $user->avatar_url,
                ];
            }),
        ];
    }
}
