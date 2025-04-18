<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Faker\Factory as Faker;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an instance of Faker to generate random data
        $faker = Faker::create();

        // Fetch the first 12 users created by the UserSeeder
        $users = DB::table('users')->limit(12)->get(); // You can adjust this if you want a different set of users
        $contentIds = DB::table('contents')->pluck('content_id'); // Get actual content IDs

        // If there are no content records, exit early
        if ($contentIds->isEmpty()) {
            Log::info('No content available to like.');
            return;
        }

        $likes = [];
        
        // For each user, randomly like some content posts
        foreach ($users as $user) {
            // Assign a random number of likes to this user, for example 3 posts per user
            $numberOfLikes = rand(1, 15); // You can change 5 to any other number to specify the max likes per user

            for ($i = 0; $i < $numberOfLikes; $i++) {
                $likes[] = [
                    'user_id' => $user->user_id,
                    'content_id' => $faker->randomElement($contentIds), // Random existing content_id
                    'created_at' => now(),
                ];
            }
        }

        // Insert the likes into the 'likes' table
        if (count($likes) > 0) {
            DB::table('likes')->insert($likes);
        }
    }
}
