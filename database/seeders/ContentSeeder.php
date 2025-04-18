<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Get all users
        $users = User::all();

        // Check if users are present
        if ($users->isEmpty()) {
            return;
        }

        // Loop to create content for each user
        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {
                $randomText = '';
                for ($j = 0; $j < 350; $j++) {
                    $randomText .= Str::random(1);
                    if (rand(1, 6) === 1) {
                        $randomText .= ' ';
                    }
                }

                // Insert content with user_id
                DB::table('contents')->insert([
                    'content_text' => $randomText,
                    'url' => 'https://www.' . Str::random(20) . '.com',
                    'img_dir' => 'bike.jpg',
                    'user_id' => $user->user_id,  // Correctly assign user_id here
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
