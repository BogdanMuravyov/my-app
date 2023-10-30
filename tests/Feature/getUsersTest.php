<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class getUsersTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetUsers(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $this->json('GET', 'api/users')->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function testGetUsersNonAuthorized()
    {
        User::factory()->create();

        $this->json('GET', 'api/users')->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }

    public function testGetUserId()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $this->json('GET', 'api/users/1')->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function testGetUserIdFail()
    {
        User::factory(2)->create();

        $this->actingAs(User::find(1), 'api');

        $this->json('GET', 'api/users/2')->assertStatus(ResponseAlias::HTTP_FORBIDDEN);
    }
}
