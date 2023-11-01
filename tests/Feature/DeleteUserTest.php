<?php

namespace Tests\Feature;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testDeleteUser(): void
    {
        $this->actingAs(User::factory()->create(), 'api');

        $this->json('DELETE', 'api/users/1')->assertStatus(ResponseAlias::HTTP_OK);

        $this->assertDatabaseHas('users', [
            'status' => 2
        ]);
    }

    public function testUserUpdateFail()
    {
        User::factory(2)->create();

        $this->actingAs(User::find(1), 'api');

        $this->json('DELETE', 'api/users/2')->assertStatus(ResponseAlias::HTTP_FORBIDDEN);
    }

    public function testUserNonAuthorized()
    {
        User::factory()->create();

        $this->json('POST', 'api/users/1')->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }
}
