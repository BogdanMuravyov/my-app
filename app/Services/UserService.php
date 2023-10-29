<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService
{
    public function store(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function updateUser(array $data, $user): void
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
    }
}
