<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function it_tests_create_method(): void
    {
        $userService = app()->make(UserService::class);
        $data = ['email' => 'dsfsdf@gmail.com', 'password' => 'Seven','name' => 'wefwfewf'];
        $createdUser = $userService->store($data);
        $this->assertInstanceOf(User::class, $createdUser);
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }
}
