<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Content;
use App\Models\Comment;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all users and contents
        $users = User::all();
        $contents = Content::all();

        foreach ($contents as $content) {
            // Get a random number of users who will comment on the post (between 1 and 5)
            $commentingUsers = $users->random(rand(1, 5));

            foreach ($commentingUsers as $user) {
                // Create a random comment for each user on this content
                $randomComment = $this->generateRandomComment(100); // Generate a random comment of 100 characters

                Comment::create([
                    'comment_text' => $randomComment,
                    'user_id' => $user->user_id, // Foreign key reference for user
                    'content_id' => $content->content_id, // Foreign key reference for content
                ]);
            }
        }
    }

    /**
     * Generate random comment text with spaces inserted at random positions.
     */
    private function generateRandomComment(int $length): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $comment = '';

        // Generate random characters and insert spaces at random intervals
        for ($i = 0; $i < $length; $i++) {
            $comment .= $characters[rand(0, strlen($characters) - 1)];
            
            // Randomly insert spaces (1 out of 5 chance)
            if (rand(1, 5) === 1) {
                $comment .= ' ';
            }
        }

        // Optionally trim any trailing spaces
        return rtrim($comment);
    }
}
