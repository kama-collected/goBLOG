<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function admindashboard(Request $request)
    {
        if (Auth::user() && Auth::user()->is_admin) {
            $users = User::all(); 
            return view('admindashboard', compact('users')); 
        } else {
            abort(403, 'Unauthorized action.');
        }
    }


    // Show Registration Form
    public function showRegister()
    {
        return view('signup');
    }

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'is_admin' => 'nullable|boolean', 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->input('is_admin', 0), 
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    // Show Login Form
    public function showLogin()
    {
        return view('login');
    }

    // Handle Login
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            Cookie::queue('user_email', Auth::user()->email, 60 * 24 * 7);
            Cookie::queue('user_name', Auth::user()->name, 60 * 24 * 7);
          
            if (Auth::user()->is_admin) {
                return redirect()->route('admindashboard');
            }
           
            //return redirect()->route('userTable');
            $user = Auth::user();
            return redirect("/feed/{$user->name}/{$user->user_id}");
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Cookie::queue(Cookie::forget('user_email'));
        Cookie::queue(Cookie::forget('user_name'));

        return redirect('/');
    }
}
