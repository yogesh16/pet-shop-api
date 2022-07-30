<?php

namespace Tests\Feature;

use App\Models\JwtToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_can_be_created_only_by_admin()
    {
        $userData = [
            'first_name' => 'test',
            'last_name' => 'admin',
            'email' => 'test@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'address' => '21 Street',
            'phone_number' => '9012312312',
            'avatar' => '4f0b35d3-0b4a-482c-9a65-95e49acbc472'
        ];

        $response = $this->json('POST', '/api/v1/admin/create', $userData, $this->getHeaders())
            ->assertStatus(200)
            ->assertJsonStructure([
                  "success",
                  "data" => [
                      "uuid",
                      "first_name",
                      "last_name",
                      "email",
                      "email_verified_at",
                      "avatar",
                      "address",
                      "phone_number",
                      "is_marketing",
                      "created_at",
                      "updated_at",
                      "last_login_at",
                      "token"
                  ],
                  "error",
                  "errors",
                  "extra"
            ]);

        $user = User::where('email', $userData['email'])->first();
        $this->assertModelExists($user);
        $this->assertIsBool(true, $user->isAdmin());
    }

    public function test_create_admin_user_unique_email_validation()
    {
        $admin = $this->getAdmin();

        $userData = [
            'first_name' => 'test',
            'last_name' => 'admin',
            'email' => $admin->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'address' => '21 Street',
            'phone_number' => '9012312312',
            'avatar' => '4f0b35d3-0b4a-482c-9a65-95e49acbc472'
        ];

        $response = $this->json('POST', '/api/v1/admin/create', $userData, $this->getHeaders($admin))
            ->assertStatus(422)
            ->assertJsonStructure([
                  "success",
                  "data",
                  "error",
                  "errors" => [
                      "email"
                  ],
                  "trace"
            ]);
    }

    protected function getHeaders($admin = null)
    {
        if(! isset($admin))
        {
            $admin = $this->getAdmin();
        }
        $token = $admin->tokens()->first();

        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token->access_token
        ];
    }

    protected function getAdmin()
    {
        $user = User::factory()->create();
        $user->is_admin = 1;
        $user->save();

        $userData = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $this->json('POST', '/api/v1/admin/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200);

        return $user;
    }
}
