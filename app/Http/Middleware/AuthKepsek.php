<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthKepsek
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna sudah login dan memiliki peran 'admin'
        if (Auth::check() && Auth::user()->role === 'kepsek') {
            return $next($request);
        }

        // Jika tidak login atau bukan admin, arahkan kembali ke halaman login
        return redirect('login')->with('failed', 'Akses ditolak! Anda bukan Kepala Sekolah.');
    }
}
