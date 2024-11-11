<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login'
        ]);
    }

    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return redirect()->intended('admin/dashboard');
    //     }

    //     return back()->with('loginError', 'Login Failed!');
    // }

    // LoginController.php

    public function login_action(Request $request)
    {
        // Validasi login
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Set session user setelah login berhasil
            Auth::login($user);

            // Mengarahkan berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin-dashboard'); // Arahkan ke dashboard admin
                case 'staff':
                    return redirect()->route('staff-dashboard'); // Arahkan ke halaman untuk staff
                case 'guru':
                    return redirect()->route('guru-dashboard'); // Arahkan ke halaman untuk guru
                case 'kepsek':
                    return redirect()->route('kepala-sekolah-dashboard'); // Arahkan ke halaman kepala sekolah
                default:
                    return redirect()->route('home'); // Pengalihan default jika tidak ada role yang sesuai
            }
        } else {
            // Menangani kegagalan login
            return back()->withErrors(['email' => 'Email atau password salah']);
        }
    }

    private function checkUser($request, $user, $role)
{
    if ($user) {  // Cek jika $user ada

        // Menyusun data user untuk disimpan dalam sesi
        $userData = [
            'id' => $user->id ?? $user->id_admin,
            'role' => $role,
            'nama' => $user->name,
            'profile' => $user->profile,
            'email' => $user->email,
            // 'divisi' => $user->divisi_id ?? null, // Jika ada
        ];

        // Simpan data user dalam sesi
        session(['user' => $userData]);

        // Redirect berdasarkan peran
        switch ($role) {
            case 'admin':
                return redirect('admin/dashboard');
            case 'guru':
                return redirect('guru/dashboard');
            case 'kepala sekolah':
                return redirect('kepala-sekolah/dashboard');
            case 'staff administrasi':
                return redirect('staff/dashboard');
            default:
                return redirect('/')->with('failed', 'Data User Tidak Ditemukan');
        }
    } else {
        return null; // Jika tidak ditemukan user, kembalikan null
    }
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
