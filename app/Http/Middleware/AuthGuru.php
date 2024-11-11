<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthGuru
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna sudah login dan memiliki peran 'admin'
        if (Auth::check() && Auth::user()->role === 'guru') {
            return $next($request);
        }

        // Jika tidak login atau bukan admin, arahkan kembali ke halaman login
        return redirect('login')->with('failed', 'Akses ditolak! Anda bukan Guru.');
    }
}
