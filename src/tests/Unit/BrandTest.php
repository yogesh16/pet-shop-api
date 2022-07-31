<?php


namespace Tests\Unit;


use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_brand()
    {
        $this->json('POST', '/api/v1/brand/create', ['title' => 'brand new'], $this->getHeaders())
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

        $this->assertDatabaseCount('brands', 1);
    }

    public function test_user_can_edit_brand()
    {
        $brand = Brand::factory()->create();
        $data['title'] = 'Kai';
        $data['slug'] = Str::slug($data['title']);

        $this->json('PUT', '/api/v1/brand/' . $brand->uuid , $data, $this->getHeaders())
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

        $brand = $brand->fresh();

        $this->assertEquals($data['title'], $brand->title);
        $this->assertEquals($data['slug'], $brand->slug);
    }

    public function test_user_can_delete_brand()
    {
        $brand = Brand::factory()->create();

        $this->assertDatabaseCount('brands', 1);

        $this->json('DELETE', '/api/v1/brand/' . $brand->uuid , [], $this->getHeaders())
            ->assertStatus(200)
            ->assertJsonStructure([
                                      "success",
                                      "data",
                                      "error",
                                      "errors",
                                      "extra"
                                  ]);

        $this->assertDatabaseCount('brands', 0);
    }

    public function test_user_can_fetch_brand()
    {
        $brand = Brand::factory()->create();

        $content = $this->json('GET', '/api/v1/brand/' . $brand->uuid , [], $this->getHeaders())
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

        $this->assertEquals($brand->uuid, $content['data']['uuid']);
    }

    public function test_user_can_list_categories()
    {
        Brand::factory(15)->create();

        $content = $this->json('GET', '/api/v1/brands', [], ['Accept' => 'application/json'])
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
                                  ]);

        $this->assertCount(10, $content['data']);
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
