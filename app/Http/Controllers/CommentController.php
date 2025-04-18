<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($content_id)
    {
        $content = Content::findOrFail($content_id);
        $comments = $content->comments;

        return view('content', compact('content', 'comments'));
    }

    public function store(Request $request, $content_id)
    {
        $request->validate([
            'comment_text' => 'required|string|max:500', 
        ]);

        Comment::create([
            'comment_text' => $request->comment_text,
            'user_id' => Auth::id(), 
            'content_id' => $content_id, 
        ]);

        return redirect()->route('content.show', ['content_id' => $content_id]);
    }

    public function show($content_id)
    {
        // Fetch the content by ID
        $content = Content::findOrFail($content_id);
        
        // Fetch comments with their associated users (eager loading)
        $comments = Comment::with('user')->where('content_id', $content_id)->get();

        // Return the view with the content and comments
        return view('content', [
            'content' => $content, 
            'comments' => $comments
        ]);
    }   

    public function destroy($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);

        if (Auth::id() !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return redirect()->route('content.show', ['content_id' => $comment->content_id])
                         ->with('success', 'Comment deleted successfully.');
    }
}
