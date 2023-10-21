<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ResetPassword extends Model
{
    use HasFactory;

    public function addResetToken($email, $token)
    {
        DB::table('password_reset_tokens')->insert([
            ['email' => $email, 'token' => $token, 'created_at' => now()]
        ]);
    }

    public function findToken($data)
    {
       return DB::table('password_reset_tokens')->where('token', $data)->first();
    }

    public function deleteToken($data)
    {
        DB::table('password_reset_tokens')->where('token', $data)->delete();
    }
}
