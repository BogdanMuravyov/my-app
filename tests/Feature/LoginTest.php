<?php

namespace Tests\Feature;

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
        $dataRegister = ['email' => 'goof@gmail.com', 'name' => 'san', 'password' => '12345678'];

        $dataLogin = ['email' => 'goof@gmail.com', 'password' => '12345678'];

        $this->json('POST', 'api/register', $dataRegister);

        $response = $this->json('POST', 'api/login', $dataLogin)->assertStatus(ResponseAlias::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'token'
        ]);
    }
}
