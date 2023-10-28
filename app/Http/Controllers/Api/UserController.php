<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserDateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function updateUserData(UpdateUserDateRequest $request, User $user)
    {
        $data = $request->validated();

        $authUser = auth()->user();

        if ($authUser->can('update', $user)) {
            $this->userService->updateUser($data, $user);

            return response()->json(['status' => ResponseAlias::HTTP_OK, 'message' => 'Your data has been changed'], ResponseAlias::HTTP_OK);
        }

        return response()->json(['status' => ResponseAlias::HTTP_FORBIDDEN, 'message' => 'You are not authorized to update this user'], ResponseAlias::HTTP_FORBIDDEN);
    }
}
