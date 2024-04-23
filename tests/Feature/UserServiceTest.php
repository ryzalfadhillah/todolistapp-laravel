<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSucces()
    {
        self::assertTrue($this->userService->login("Admin", "password1"));
    }

    public function testLoginFail()
    {
        self::assertFalse($this->userService->login("Admin", "password"));
    }

    public function testLoginFailUserNotFound()
    {
        self::assertFalse($this->userService->login("Guest", "password1"));
    }
}
