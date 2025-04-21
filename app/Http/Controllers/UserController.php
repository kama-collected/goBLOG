<?php

namespace App\Http\Controllers;

use App\Models\content;
use App\Models\likes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Comment;
use app\Models\Category;
use function Pest\Laravel\postJson;

class UserController extends Controller
{

    public function checkLogIn()
    {
        if (Auth::check()) {
            // Logged in
            $user = Auth::user();
            return redirect()->route('user.feed', ['name' => $user->name, 'user_id' => $user->user_id]);
        }
        // Not logged in
        return redirect('/login');
    }
    
    public function create()
    {
          return view('create'); 
    }

    public function destroy($id)
    { 
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }
        // Find the user
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Redirect with success message
        return redirect()->back()->with('success', 'User deleted successfully.');

    }

    public function edit($id)
    { if (!Auth::user()->is_admin) {
        abort(403, 'Unauthorized');
    }
        $user = User::findOrFail($id);
        return view('edit', compact('user'));
    }

    public function update(Request $request, $id)
    { 
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        // Validate request
        $request->validate([
            'name' => 'required|string|min:3|max:255|regex:/^[a-zA-Z0-9\s._-]+$/',
            'email' => 'required|email|unique:users,email,' . $id,
            'is_admin' => 'required|boolean',
        ]);

        // Find user
        $user = User::findOrFail($id);

        // Update user data
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'is_admin' => $request->input('is_admin'),
        ]);

        // Redirect with success message
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function editUser()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|min:3|max:255|regex:/^[a-zA-Z0-9\s._-]+$/',
            'email' => 'required|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated!');
    }

    public function index(Request $request)
    {
        $query = User::query(); // Start query builder

        // Apply filters if provided
        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }
        if ($request->filled('is_admin')) {
            $query->where('is_admin', $request->is_admin);
        }

        $users = $query->get(); // Get filtered users

        return view('userTable', compact('users'));
    }
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|min:3|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email',
            'password' => 'required|string|min:3'
        ]);

        // Find user by email
        $user = User::whereRaw('LOWER(email) = LOWER(?)', [$request->email])
        ->whereRaw('LOWER(name) = LOWER(?)', [$request->name])
        ->first();
        dd($user);
        // Check if user exists
        if (!$user) {
            return back()->withErrors(['email' => 'User not found'])->withInput();


        }if (trim($user->name) !== trim($request->name)) {
            return back()->withErrors(['name' => 'Invalid name.'])->withInput();
        }

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid password.'])->withInput();
        }

        // Authenticate user
        Auth::login($user, $request->filled('remember'));

        // Handle "Remember Me" functionality
        if ($request->filled('remember')) {
            Cookie::queue('user_email', $user->email, 10080);
            Cookie::queue('user_name', $user->name, 10080);
            Cookie::queue('session_token', encrypt($user->id . '|' . now()), 10080);
        } else {
            Cookie::queue(Cookie::forget('user_email'));
        }

        // Redirect based on user role
        return redirect()->route($user->role === 'admin' ? 'admindashboard' : 'userTable')
                         ->with('success', 'Login successful');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Remove cookies
        Cookie::queue(Cookie::forget('user_email'));
        Cookie::queue(Cookie::forget('session_token'));

        return redirect('/login')->with('success', 'You have been logged out');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'is_admin' => 'required|boolean'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => $request->is_admin
        ]);

        return redirect()->route('admindashboard')->with('success', 'User created successfully');
    }

 
    public function UserInner($id)
    {
        $user = User::findOrFail($id);

        $posts = $user->posts()->latest()->get();
        $comments = $user->comments()->latest()->get();
        $likedPosts = $user->likes()->with('post')->latest()->take(5)->get();

        return view('UserInner', compact('user', 'posts', 'comments', 'likedPosts'));
    }

    public function home()
    {
        $user = Auth::user();

        // Get sorting parameter (default to 'latest')
        $sort = request('sort', 'latest');
        
        // Base query with relationships and counts
        $query = Content::with(['user', 'categories'])
            ->withCount(['likes', 'comments']);
        
        // Apply sorting
        switch ($sort) {
            case 'popular':
                $query->orderBy('likes_count', 'desc');
                break;
            case 'commented':
                $query->orderBy('comments_count', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default: // 'latest'
                $query->latest();
        }
        
        // Paginate results
        $contents = $query->paginate(10);
        
        return view('home', [
            'contents' => $contents,
            'currentSort' => $sort,
            'user' => Auth::user(),
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        $contents = $user->contents()
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(10);
            
        $comments = $user->comments()
            ->with('content')
            ->latest()
            ->paginate(5);
            
        $likedContents = $user->likes()
            ->with('content')
            ->latest()
            ->paginate(5);

        return view('users.profile', compact('user', 'contents', 'comments', 'likedContents'));
    }


    public function getPost($id)
    {
        // Find the content with its relationships loaded
        $content = Content::with(['user', 'comments.user', 'likes'])
            ->withCount(['comments', 'likes'])
            ->findOrFail($id);

        // Get related contents (optional)
        $relatedContents = Content::where('id', '!=', $id)
            ->whereHas('categories', function($query) use ($content) {
                $query->whereIn('categories.id', $content->categories->pluck('id'));
            })
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('contents.show', [
            'content' => $content,
            'relatedContents' => $relatedContents
        ]);
    }

    public function loadContent(){
        $contents= content::select('text','url','img_dir')->paginate(5);

        return view ('contentdashboard',['contents'=>$contents]);
    }

    public function viewUserContent(User $user)
    {
        $contents = $user->contents()
            ->with(['comments.user', 'likes']) // eager load user who made each comment
            ->latest()
            ->get();
    
        return view('admin.user_contents', compact('user', 'contents'));
    }
}

