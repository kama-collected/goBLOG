<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate the users table to remove any existing users
        User::truncate();

        // Creating the Admin and User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'is_admin' => 1,
        ]);
        
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'is_admin' => 0,
        ]);

        // Create 10 random users
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('111111'),
                'is_admin' => 0,
            ]);
        }
    }
}
