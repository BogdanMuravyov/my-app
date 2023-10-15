<?php

namespace App\Services;
use App\Models\User;

class UserService
{
    public function store(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' =>$data['password'],
        ]);
        return $user;
    }
}
