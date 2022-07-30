<?php

namespace Tests\Feature;

use App\Models\JwtToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_without_log_in_user_can_not_access()
    {
        $this->json('POST', '/api/v1/admin/create', $this->getUserData(), ['Accept' => 'application/json',])
            ->assertStatus(401)
            ->assertJsonStructure([
                  "success",
                  "data",
                  "error",
                  "errors",
                  "trace"
            ]);
    }

    public function test_admin_user_can_be_created_only_by_admin()
    {
        $userData = $this->getUserData();

        $this->json('POST', '/api/v1/admin/create', $userData, $this->getHeaders())
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

        $userData = $this->getUserData();
        $userData['email'] = $admin->email;

        $this->json('POST', '/api/v1/admin/create', $userData, $this->getHeaders($admin))
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

    public function test_get_user_lists()
    {
        User::factory(10)->create();

        $content = $this->json('GET', '/api/v1/admin/user-listing', [], $this->getHeaders())
            ->assertStatus(200)
            ->assertJsonStructure([
                  "current_page",
                  "data",
                  "first_page_url",
                  "from",
                  "last_page",
                  "last_page_url",
                  "links",
                  "next_page_url",
                  "path",
                  "per_page",
                  "prev_page_url",
                  "to",
                  "total"
            ])
            ->decodeResponseJson();

        $this->assertCount(10, $content['data']);
    }

    public function test_get_user_filter_by_email()
    {
        User::factory(10)->create();
        $user = User::first();

        $content = $this->json('GET', '/api/v1/admin/user-listing', ['email' => $user->email], $this->getHeaders())
            ->assertStatus(200)
            ->assertJsonStructure([
                                      "current_page",
                                      "data",
                                      "first_page_url",
                                      "from",
                                      "last_page",
                                      "last_page_url",
                                      "links",
                                      "next_page_url",
                                      "path",
                                      "per_page",
                                      "prev_page_url",
                                      "to",
                                      "total"
                                  ])
            ->decodeResponseJson();

        $this->assertCount(1, $content['data']);
    }

    public function test_get_user_limit()
    {
        User::factory(10)->create();

        $content = $this->json('GET', '/api/v1/admin/user-listing', ['limit' => 5], $this->getHeaders())
            ->assertStatus(200)
            ->assertJsonStructure([
                                      "current_page",
                                      "data",
                                      "first_page_url",
                                      "from",
                                      "last_page",
                                      "last_page_url",
                                      "links",
                                      "next_page_url",
                                      "path",
                                      "per_page",
                                      "prev_page_url",
                                      "to",
                                      "total"
                                  ])
            ->decodeResponseJson();

        $this->assertCount(5, $content['data']);
    }


    private function getUserData()
    {
        return [
            'first_name' => 'test',
            'last_name' => 'admin',
            'email' => 'test@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'address' => '21 Street',
            'phone_number' => '9012312312',
            'avatar' => '4f0b35d3-0b4a-482c-9a65-95e49acbc472'
        ];
    }

    private function getHeaders($admin = null)
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

    private function getAdmin()
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
