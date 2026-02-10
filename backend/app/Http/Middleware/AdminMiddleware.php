<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Admin user ko allow kare
            return $next($request);
        }

        // Agar admin nahi hai, redirect kar do ya 403 show karo
        abort(403, 'Unauthorized access.');
    }
}
