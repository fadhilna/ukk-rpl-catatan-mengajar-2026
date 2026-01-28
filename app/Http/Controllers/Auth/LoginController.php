<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user di database
        $user = Pengguna::where('username', $request->username)->first();
        
        // Debug: lihat data user
        // dd($user);
        
        // Verifikasi password (MD5 karena di database kita pakai MD5)
        if ($user && md5($request->password) === $user->password) {
            // Simpan data di session
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'peran' => $user->peran,
                'logged_in' => true
            ]);
            
            // Redirect berdasarkan role
            if ($user->peran == 'admin') {
                return redirect('/guru')->with('success', 'Login berhasil sebagai Admin');
            } else {
                return redirect('/')->with('success', 'Login berhasil sebagai Guru');
            }
        }
        
        // Jika login gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        // Hapus semua session
        session()->flush();
        
        // Redirect ke halaman login
        return redirect('/login')->with('success', 'Logout berhasil');
    }
}