<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('logged_in') || session('peran') != 'admin') {
            return redirect('/login')->with('error', 'Akses ditolak. Hanya untuk admin.');
        }
        
        return $next($request);
    }
}

