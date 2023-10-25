<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLogin(): void
    {
        $user = User::factory()->create();

        $data = ['email' => $user->email, 'password' => 'password'];

        $response = $this->json('POST', 'api/login', $data)->assertStatus(ResponseAlias::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'token'
        ]);
    }

    public function testWrongData()
    {
        $this->json('POST', 'api/login')->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testWrongPassword()
    {
        $this->json('POST', 'api/login', ['email' => 'asdfas@gmail.com'])->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testWrongEmail()
    {
        $this->json('POST', 'api/login', ['password' => '123'])->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }
}
