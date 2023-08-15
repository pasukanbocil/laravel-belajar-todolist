<?php

namespace Tests\Feature;

use App\Services\UserSevice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserSevice $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserSevice::class);
    }

    public function testLoginSuccess()
    {
        self::assertTrue($this->userService->login("khannedy", "rahasia"));
    }

    public function testLoginUserNotFound()
    {
        self::assertFalse($this->userService->login("dicky","dicky"));
    }

    public function testLoginWrongPassword()
    {
        self::assertFalse($this->userService->login("khannedy","salah"));
    }

}
