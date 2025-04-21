<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Factory as Faker;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Faker instance
        $faker = Faker::create();

        // Get all users
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        // Create content for each user
        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {
                DB::table('contents')->insert([
                    'content_title' => $faker->sentence,
                    'content_body' => $faker->paragraph,
                    'url' => 'https://www.' . Str::random(20) . '.com',
                    'img_dir' => 'bike.jpg',
                    'user_id' => $user->user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
