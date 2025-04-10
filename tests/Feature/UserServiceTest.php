<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        // self::assertTrue(true);
        $this->userService = $this->app->make(UserService::class);
    }

    public function test_sample()
    {
        self::assertTrue(true);
    }

    public function test_login_success()
    {
        self::assertTrue($this->userService->login("Hanif", "rahasiabro"));
    }

    public function test_user_not_found()
    {
        self::assertFalse($this->userService->login("Aulia", "rahasiabro"));
    }

    public function test_wrong_password(){
        self::assertFalse($this->userService->login("Hanif", "rahasia123"));
    }
}
