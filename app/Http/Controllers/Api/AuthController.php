<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StorePostRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(StorePostRequest $request)
    {
        $user = $this->userService->store($request->validated());

        $token = $user->createToken('Token Name')->accessToken;

        return  response()->json(['success' => true, 'token' => $token], ResponseAlias::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {

        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        }

        $user = User::where('email', $credentials['email'])->first();

        $token = $user->createToken('Token Name')->accessToken;

        return response()->json(['status' => ResponseAlias::HTTP_OK, 'token' => $token], ResponseAlias::HTTP_OK);
    }
}
