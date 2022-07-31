<?php


namespace Tests\Unit;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created()
    {
        $this->json('POST', '/api/v1/category/create', ['title' => 'category new'], $this->getHeaders())
            ->assertStatus(200)
            ->assertJsonStructure([
                                      "success",
                                      "data" => [
                                          "uuid"
                                      ],
                                      "error",
                                      "errors",
                                      "extra"
                                  ]);
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
