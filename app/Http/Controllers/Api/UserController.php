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

        $this->userService->updateUser($data, $user);

        return response()->json(['status' => ResponseAlias::HTTP_OK, 'message' => 'Your data has been changed'], ResponseAlias::HTTP_OK);
    }

    public function getAllUsersArray()
    {
        $collection = User::pluck('email')->toArray();

        return response()->json(['users' => $collection]);
    }

    public function getOneAuthUserArray(User $id)
    {
        $user = User::find($id);

        $this->authorize('view', $id);

        $userData = $user->pluck('email')->toArray();

        return response()->json(['user' => $userData]);
    }
}
