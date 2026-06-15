<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;
use App\Models\Category;
use App\Models\User;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::first();
        $user = User::where('role', 'seller')->first();

        Listing::create([
            'title' => 'Vintage Lamp',
            'description' => 'Beautiful vintage lamp in working condition',
            'price' => 45.99,
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
    }
}
