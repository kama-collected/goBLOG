<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Content;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Content::truncate();

        for ($i = 0; $i < 5; $i++) {
            $randomText = '';
            for ($j = 0; $j < 350; $j++) {

                $randomText .= Str::random(1);

                if (rand(1, 6) === 1) {
                    $randomText .= ' ';
                }
            }
    
            DB::table('contents')->insert([
                'content_text' => $randomText,
                'url' => 'https://www.' . Str::random(20) . '.com',
                'img_dir' => 'bike.jpg',
                'user_id' => 1,
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            $randomText = '';
            for ($j = 0; $j < 350; $j++) {

                $randomText .= Str::random(1);

                if (rand(1, 6) === 1) {
                    $randomText .= ' ';
                }
            }
    
            DB::table('contents')->insert([
                'content_text' => $randomText,
                'url' => 'https://www.' . Str::random(20) . '.com',
                'img_dir' => 'bike.jpg',
                'user_id' => 2,
            ]);
        }
    }
}
