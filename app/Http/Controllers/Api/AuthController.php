<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required | string',
            'email' => 'required | string | unique:users',
            'password' => 'required | confirmed'
    ]);

        if ($validator->fails()) {
            return Response(['errors' => $validator->errors()->all()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if (!$user) {
            return response()->json(['success' => false, "message" => "Registration failed"], 500);
        }
        return  response()->json(["success" => true, "message" => "Registration succeeded"], 500);
    }
}
