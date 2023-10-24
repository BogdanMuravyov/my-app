<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ResetPassword extends Model
{
    use HasFactory;

    public function addResetToken($user_id, $token)
    {
        DB::table('reset_passwords')->insert([
            ['user_id' => $user_id, 'token' => $token, 'created_at' => now()]
        ]);
    }

    public function deleteToken($data)
    {
        DB::table('reset_passwords')->where('token', $data)->delete();
    }
}
