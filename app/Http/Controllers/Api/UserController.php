<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\GetUserRequest;
use App\Http\Requests\UpdateUserDateRequest;
use App\Mail\DeleteOrderShipped;
use App\Models\User;
use App\Services\UserService;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Mail\Attachment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    public function index()
    {
        $collection = User::pluck('email')->toArray();

        return response()->json(['users' => $collection]);
    }

    public function view(GetUserRequest $request, User $user)
    {
        return response()->json(['user' => $user]);
    }

    public function delete(DeleteUserRequest $request, User $user)
    {
        $user->update(['status' => User::INACTIVE]);

        $pdf = Pdf::loadView('pdf');

        $mail = new DeleteOrderShipped();
        $mail->attachData($pdf->output(), 'delete-user.pdf', ['mime' => 'application/pdf']);

        Mail::to($user->email)->send($mail);

        return response()->json(['message' => 'Your account has been deactivated']);
    }
}
