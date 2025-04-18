<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Content;

class LikeController extends Controller
{
    public function like(Content $content)
    {
        $userId = auth()->id();

        // Prevent duplicate likes
        $existingLike = DB::table('likes')
            ->where('user_id', $userId)
            ->where('content_id', $content->content_id)
            ->first();
    
        if (!$existingLike) {
            DB::table('likes')->insert([
                'user_id' => $userId,
                'content_id' => $content->content_id,
                'created_at' => now()
            ]);
        }

        // Return updated like count
        $count = DB::table('likes')
            ->where('content_id', $content->content_id)
            ->count();

        return response()->json(['likes_count' => $count]);
    }

    public function unlike(Content $content)
    {
        $userId = auth()->id();

        DB::table('likes')
            ->where('user_id', $userId)
            ->where('content_id', $content->content_id)
            ->delete();

        // Return updated like count
        $count = DB::table('likes')
            ->where('content_id', $content->content_id)
            ->count();

        return response()->json(['likes_count' => $count]);
    }
}
