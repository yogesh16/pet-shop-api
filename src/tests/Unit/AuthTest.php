<?php


namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login()
    {
        $user = User::factory()->create();
        $user->is_admin = 1;
        $user->save();

        $userData = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $this->json('POST', '/api/v1/admin/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "data" => [
                    "token"
                ],
                "error",
                "errors",
                "extra"
            ]);

        $this->assertAuthenticated();
    }

    public function test_admin_can_not_login_with_false_credentials()
    {
        $user = User::factory()->create();
        $user->is_admin = 1;
        $user->save();

        $userData = [
            'email' => $user->email,
            'password' => '12345678'
        ];
        $this->json('POST', '/api/v1/admin/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "success" => 0,
                "data" => [],
                "error" => "Invalid username or password",
                "errors" => [],
                "trace" => []
             ]);
    }

    public function test_only_admin_can_login()
    {
        $user = User::factory()->create();

        $userData = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $this->json('POST', '/api/v1/admin/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                  "success",
                  "data",
                  "error",
                  "errors",
                  "trace"
            ]);

        $this->assertAuthenticated();
    }
}
