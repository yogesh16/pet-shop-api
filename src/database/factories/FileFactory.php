<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->text(50),
            'path' => fake()->imageUrl(),
            'size' => fake()->numberBetween(5 * 1024, 20 * 1024),
            'type' => 'image/png'
        ];
    }
}
