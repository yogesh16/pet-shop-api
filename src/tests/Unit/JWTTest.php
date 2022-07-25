<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\JWTService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JWTTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_jwt_token()
    {
        $user = User::factory()->create();
        $token = $user->generateToken();

        $this->assertIsString($token);
    }

    public function test_decode_jwt_token()
    {
        $user = User::factory()->create();
        $token = $user->generateToken();

        $newUser = JWTService::parseToken($token);

        $this->assertEquals($user->uuid, $newUser->uuid);
    }
}
