<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $metaData = [
            'brand' => Brand::all()->random()->uuid,
            'image' => File::all()->random()->uuid
        ];

        return [
            'category_uuid' => Category::all()->random()->uuid,
            'title' => fake()->text(),
            'price' => fake()->randomFloat(2, 10, 1000),
            'description' => fake()->paragraph(1),
            'metadata' => json_encode($metaData)
        ];
    }
}
