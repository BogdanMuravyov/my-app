<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SetPasswordRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\ResetPassword;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\OrderShipped;

class AuthController extends Controller
{
    protected UserService $userService;
    protected ResetPassword $resetPassword;

    public function __construct(UserService $userService, ResetPassword $resetPassword)
    {
        $this->userService = $userService;
        $this->resetPassword = $resetPassword;
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
            $user = User::where('email', $credentials['email'])->first();

            $token = $user->createToken('Token Name')->accessToken;

            return response()->json(['status' => ResponseAlias::HTTP_OK, 'token' => $token], ResponseAlias::HTTP_OK);
        }

        return response()->json(['message' => 'Wrong credentials'], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function sendResetPasswordEmail(ResetPasswordRequest $request)
    {
        $email = $request->validated();

        $user = User::where('email', $email['email'])->first();

        if ($user) {
            $token = Str::random(60);

            $this->resetPassword->addResetToken($email['email'], $token);

            Mail::to($user->email)->send(new OrderShipped($token));

            return response()->json(['status' => ResponseAlias::HTTP_OK, 'message' => 'An email with instructions has been sent to your email!'], ResponseAlias::HTTP_OK);
        }

        return response()->json(['message' => 'No user with this email was found.'], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function setNewPassword(SetPasswordRequest $request)
    {
     $data = $request->validated();

     $token = $this->resetPassword->findToken($data['token']);

     if ($token['created_at']->addHours(2) < now()) {
         $this->resetPassword->deleteToken($data['token']);

         return response()->json(['message' => 'Expired token. Please generate a new token.'], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
     }

     if ($token) {
         DB::table('users')
             ->where('email', $token->email)
             ->update(['password' => Hash::make($data['password'])]);

         $this->resetPassword->deleteToken($data['token']);

         return response()->json(['status' => ResponseAlias::HTTP_OK, 'message' => 'Your password has been changed'], ResponseAlias::HTTP_OK);
     }

     return response()->json(['message' => 'Wrong token.'], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }
}
