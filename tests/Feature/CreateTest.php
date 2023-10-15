<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use DatabaseMigrations;
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    /**
     * test
     */
    public function testRegister(): void
    {
        $data = ['email' => 'goof@gmail.com', 'name' => 'san', 'password' => '12345678'];

        $response = $this->json('POST', 'api/register', $data)->assertStatus(201);

        $response->assertJsonStructure([
            'success',
            'token'
        ]);
    }
}
