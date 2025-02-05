<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsUser
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan pengguna sudah login dan memiliki role 'user'
        if (!Auth::check() || Auth::user()->role !== 'user') {
            return redirect('/')->with('error', 'Akses hanya untuk pengguna dengan role user.');
        }

        return $next($request);
    }
}
