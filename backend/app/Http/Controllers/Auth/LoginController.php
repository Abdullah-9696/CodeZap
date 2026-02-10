<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login'); 
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Admin role -> Admin dashboard
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } 
            // User role -> React frontend
            else {
                return redirect()->away('http://localhost:3000/'); 
                // 🔑 apne frontend ka URL yahan daalna
            }
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
