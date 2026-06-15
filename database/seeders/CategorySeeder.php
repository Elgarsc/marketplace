<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Electronics', 'description' => 'Electronic devices and gadgets']);
        Category::create(['name' => 'Furniture', 'description' => 'Home furniture and decor']);
        Category::create(['name' => 'Clothing', 'description' => 'Apparel and fashion items']);
        Category::create(['name' => 'Books', 'description' => 'Books and reading materials']);
        Category::create(['name' => 'Sports', 'description' => 'Sports equipment and gear']);
    }
}
