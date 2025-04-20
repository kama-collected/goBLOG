<?php
//  Added by kama (used)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Content;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;

class ContentController extends Controller
{
    public function index(){
        $contents = Content::all();
         
        return view('feed', ['contents' => $contents]);
    }

    // Show the feed for a specific user
    public function showFeed($name, $user_id)
    {

        if (Auth::user()->user_id != $user_id) {
            abort(403); // Prevent others from viewing the feed
        }

        $user = User::findOrFail($user_id);
        $contents = Content::where('user_id', $user_id)->get();
        $likedContentIDs = Like::where('user_id', $user->user_id)->pluck('content_id')->toArray();

        foreach ($contents as $content) {
            $content->likes_count = Like::where('content_id', $content->content_id)->count(); // Count likes for each post
        }

        return view('feed', [
            'contents' => $contents,
            'user' => $user,
            'likedContentIDs' => $likedContentIDs,
        ]);
    }

    // Explore Page
    public function explore()
    {
        $contents = Content::with('user')->get();
        $likedContentIDs = Like::where('user_id', Auth::id())->pluck('content_id')->toArray();

        foreach ($contents as $content) {
            $content->likes_count = Like::where('content_id', $content->content_id)->count();
        }

        return view('explore', [
            'contents' => $contents,
            'likedContentIDs' => $likedContentIDs,
        ]);
    }

    public function exploreUser($user_id)
    {
        $user = User::findOrFail($user_id);
        $contents = Content::where('user_id', $user_id)->get();
        $likedContentIDs = Like::where('user_id', Auth::id())->pluck('content_id')->toArray();

        foreach ($contents as $content) {
            $content->likes_count = Like::where('content_id', $content->content_id)->count();
        }

        return view('explore', compact('user', 'contents', 'likedContentIDs'));
    }

    public function show($content_id){
        $content = Content::findOrFail($content_id);
        $comments = Comment::where('content_id', $content_id)->get();

        return view('content', ['content' => $content, 'comments' => $comments]);
    }

    public function create() {
        return view ('content.create');
    }

    public function edit($id) {
        $content = Content::findOrFail($id);
        return view('content.edit', compact('content'));
    }
    
    public function update(Request $request, $id) {
        $content = Content::findOrFail($id);
        $content->update($request->all());
        return redirect()->route('user.feed', ['name' => Auth::user()->name, 'user_id' => Auth::user()->id]);
    }
    
    public function destroy($id) {
        $content = Content::findOrFail($id);
        $content->delete();
        return back()->with('message', 'Post deleted successfully.');
    }    

    public function store(Request $request) {
        $user = Auth::user();

        if ($request->hasFile('img_dir')) {
            $imagePath = $request->file('img_dir')->store('images', 'public');
        } else {
            $imagePath = null;
        }

        Content::create([
            'content_text' => request('text_upload'),
            'url' => request('urllink') ?? null, 
            'img_dir' => request('img_dir') ?? null,
            'user_id' => Auth::user()->user_id,
        ]);

        return redirect()->route('user.feed', [
            'name' => $user->name,
            'user_id' => $user->user_id
        ]);
    }
}
