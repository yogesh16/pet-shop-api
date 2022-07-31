<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(50)->create();

        User::factory()->create([
             'first_name' => 'Admin',
             'last_name' => 'User',
             'is_admin' => 1,
             'email' => 'admin@petshop.com'
        ]);

        Category::factory(10)->create();

        Brand::factory(10)->create();

        File::factory(15)->create();

        Product::factory(50)->create();
    }
}
