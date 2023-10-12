<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
class AuthController extends Controller
{
    public function register(StorePostRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('Token Name')->accessToken;

        return  response()->json(['success' => true, 'message' => 'Registration succeeded'], 201);
    }
}
