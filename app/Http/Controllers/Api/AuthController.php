<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use function Laravel\Prompts\password;

class AuthController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(StorePostRequest $request)
    {
        $user = $this->userService->store([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
        ]);

        $token = $user->createToken('Token Name')->accessToken;

        return  response()->json(['success' => true, 'token' => $token], 201);
    }
}
