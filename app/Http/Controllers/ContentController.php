<?php
//  Added by kama (used)
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Content;
use App\Models\User;
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

    public function explore()
    {
        $contents = Content::with('user')->get(); // eager load user for displaying name
        $likedContentIDs = Like::where('user_id', Auth::id())->pluck('content_id')->toArray();

        foreach ($contents as $content) {
            $content->likes_count = Like::where('content_id', $content->content_id)->count();
        }

        return view('explore', [
            'contents' => $contents,
            'likedContentIDs' => $likedContentIDs,
        ]);
    }


    public function show($content_id){
        $content = Content::findOrFail($content_id);

        return view('content.show', ['content' => $content]);
    }

    public function create() {
        return view ('content.create');
    }

    public function destroy($content_id) {
        $content = Content::findOrFail($content_id);
        $content->delete();

        return redirect('/');
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
