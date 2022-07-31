<?php


namespace Tests\Unit;


use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_category()
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

    public function test_user_can_edit_category()
    {
        $category = Category::factory()->create();
        $data['title'] = 'New Pet Store';
        $data['slug'] = Str::slug($data['title']);

        $this->json('PUT', '/api/v1/category/' . $category->uuid , $data, $this->getHeaders())
            ->assertStatus(200)
            ->assertJsonStructure([
                                      "success",
                                      "data" => [
                                          "uuid",
                                          "title",
                                          "slug",
                                          "created_at",
                                          "updated_at"
                                      ],
                                      "error",
                                      "errors",
                                      "extra"
                                  ]);

        $category = $category->fresh();

        $this->assertEquals($data['title'], $category->title);
        $this->assertEquals($data['slug'], $category->slug);
    }

    public function test_user_can_delete_category()
    {
        $category = Category::factory()->create();

        $this->assertDatabaseCount('categories', 1);

        $this->json('DELETE', '/api/v1/category/' . $category->uuid , [], $this->getHeaders())
            ->assertStatus(200)
            ->assertJsonStructure([
                                      "success",
                                      "data",
                                      "error",
                                      "errors",
                                      "extra"
                                  ]);

        $this->assertDatabaseCount('categories', 0);
    }

    public function test_user_can_fetch_category()
    {
        $category = Category::factory()->create();

        $content = $this->json('GET', '/api/v1/category/' . $category->uuid , [], $this->getHeaders())
            ->assertStatus(200)
            ->assertJsonStructure([
                                      "success",
                                      "data" => [
                                          "uuid",
                                          "title",
                                          "slug",
                                          "created_at",
                                          "updated_at"
                                      ],
                                      "error",
                                      "errors",
                                      "extra"
                                  ])
            ->decodeResponseJson();

        $this->assertEquals($category->uuid, $content['data']['uuid']);
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
