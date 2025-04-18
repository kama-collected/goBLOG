<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // ✅ Validate input
        $credentials = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        // ✅ Attempt authentication
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate(); // Prevent session fixation attacks
            
            // ✅ Store Cookies for Remember Me
            Cookie::queue('user_email', Auth::user()->email, 60 * 24 * 7);
            Cookie::queue('user_name', Auth::user()->name, 60 * 24 * 7);

            // ✅ Redirect based on admin status
            return Auth::user()->is_admin 
                ? redirect()->route('admindashboard')->with('success', 'Welcome Admin!')
                : redirect()->route('userTable')->with('success', 'Welcome User!');
        }

        // ❌ Authentication Failed
        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ✅ Remove cookies
        Cookie::queue(Cookie::forget('user_email'));
        Cookie::queue(Cookie::forget('user_name'));

        return redirect('/login')->with('success', 'You have been logged out');
    }
}
