<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@marketplace.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Test Seller',
            'email' => 'seller@marketplace.com',
            'password' => Hash::make('password123'),
            'role' => 'seller',
        ]);

        User::create([
            'name' => 'Test Buyer',
            'email' => 'buyer@marketplace.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}
