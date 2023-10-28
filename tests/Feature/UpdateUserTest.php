<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     */
    public function testUserUpdate(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $data = ['email' => 'Jhon@gmail.com', 'name' => 'Jhonsen'];

        $this->json('POST', 'api/users/1', $data)->assertStatus(ResponseAlias::HTTP_OK);

        $this->assertDatabaseHas('users', [
            'email' => 'Jhon@gmail.com',
            'name' => 'Jhonsen'
        ]);
    }

    public function testUserUpdateFail()
    {
        User::factory(2)->create();

        $this->actingAs(User::find(1), 'api');

        $this->json('POST', 'api/users/2')->assertStatus(ResponseAlias::HTTP_FORBIDDEN);
    }

    public function testUserNonAuthorized()
    {
        User::factory()->create();

        $this->json('POST', 'api/users/2')->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }
}
