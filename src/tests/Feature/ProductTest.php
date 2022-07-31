<?php


namespace Tests\Feature;


use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_products()
    {
        $this->createProducts();

        $data = $this->json('GET', '/api/v1/products', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->decodeResponseJson();

        $this->assertCount(10, $data['data']);
    }

    protected function createProducts()
    {
        Category::factory(5)->create();
        Brand::factory(5)->create();
        File::factory(10)->create();
        Product::factory(20)->create();
    }
}
