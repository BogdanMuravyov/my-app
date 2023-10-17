<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CreateTest extends TestCase
{
    /**
     * test
     */
    public function testRegister(): void
    {
        $data = ['email' => 'goof@gmail.com', 'name' => 'san', 'password' => '12345678'];

        $response = $this->json('POST', 'api/register', $data)->assertStatus(ResponseAlias::HTTP_CREATED);

        $response->assertJsonStructure([
            'success',
            'token'
        ]);
    }
}
