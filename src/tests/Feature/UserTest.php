<?php


namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $userData = $this->getUserData();

        $this->json('POST', '/api/v1/user/create', $userData, ['Accept' => 'application/json'])
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
    }

    public function test_create_user_unique_email_validation()
    {
        $user = $this->getUser();

        $userData = $this->getUserData();
        $userData['email'] = $user->email;

        $this->json('POST', '/api/v1/user/create', $userData, $this->getHeaders($user))
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

        $this->assertDatabaseCount('users', 1);
    }

    //Helper functions

    private function getUserData()
    {
        return [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@user.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'address' => '21 Street',
            'phone_number' => '9012312312',
            'avatar' => '4f0b35d3-0b4a-482c-9a65-95e49acbc472'
        ];
    }

    //get headers array
    private function getHeaders($user = null)
    {
        if(! isset($user))
        {
            $user = $this->getUser();
        }
        $token = $user->tokens()->first();

        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token->access_token
        ];
    }

    //return user
    private function getUser()
    {
        $user = User::factory()->create();

        $userData = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $this->json('POST', '/api/v1/user/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200);

        return $user;
    }
}
