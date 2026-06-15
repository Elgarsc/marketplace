<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;
use App\Models\Category;
use App\Models\User;
use App\Models\ListingImage;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::first();
        $user = User::where('role', 'seller')->first() ?? User::first();

        $electronics = Category::where('name', 'Electronics')->first();
        $furniture = Category::where('name', 'Furniture')->first();
        $other = Category::where('name', 'Other')->first();

        $lamp = Listing::create([
            'title' => 'Vintage Lamp',
            'description' => 'Beautiful vintage lamp in working condition. Great for home decor.',
            'price' => 45.99,
            'currency' => 'EUR',
            'status' => 'active',
            'category_id' => $furniture->id ?? $category->id,
            'user_id' => $user->id,
        ]);
        ListingImage::create([
            'listing_id' => $lamp->id,
            'image_path' => 'listings/lamp.jpg',
        ]);
        ListingImage::create([
            'listing_id' => $lamp->id,
            'image_path' => 'listings/lamp.jpg',
        ]);

        $car = Listing::create([
            'title' => 'Used Car',
            'description' => 'This is my old car in decent running condition. Fresh technical inspection.',
            'price' => 80.00,
            'currency' => 'USD',
            'status' => 'active',
            'category_id' => $other->id ?? $category->id,
            'user_id' => $user->id,
        ]);
        ListingImage::create([
            'listing_id' => $car->id,
            'image_path' => 'listings/car.jpg',
        ]);
        ListingImage::create([
            'listing_id' => $car->id,
            'image_path' => 'listings/car.jpg',
        ]);

        $ps5 = Listing::create([
            'title' => 'Sony PlayStation 5',
            'description' => 'Full set with two controllers and 3 games included. Barely used.',
            'price' => 380.00,
            'currency' => 'EUR',
            'status' => 'active',
            'category_id' => $electronics->id ?? $category->id,
            'user_id' => $user->id,
        ]);
        ListingImage::create([
            'listing_id' => $ps5->id,
            'image_path' => 'listings/ps5.jpg',
        ]);
        ListingImage::create([
            'listing_id' => $ps5->id,
            'image_path' => 'listings/ps5.jpg',
        ]);


        $iphone = Listing::create([
            'title' => 'iPhone 13 Pro',
            'description' => 'Good condition, no visual defects. Battery capacity 88%. Charger included.',
            'price' => 420.00,
            'currency' => 'EUR',
            'status' => 'sold',
            'category_id' => $electronics->id ?? $category->id,
            'user_id' => $user->id,
        ]);
        ListingImage::create([
            'listing_id' => $iphone->id,
            'image_path' => 'listings/ps5.jpg',
        ]);


        $sofa = Listing::create([
            'title' => 'Corner Sofa',
            'description' => 'Used for two years. Clean fabric, very comfortable. Self-pickup only.',
            'price' => 150.00,
            'currency' => 'EUR',
            'status' => 'sold',
            'category_id' => $furniture->id ?? $category->id,
            'user_id' => $user->id,
        ]);
        ListingImage::create([
            'listing_id' => $sofa->id,
            'image_path' => 'listings/lamp.jpg',
        ]);
    }
}
