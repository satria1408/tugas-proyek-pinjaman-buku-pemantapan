<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan form login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses Login (Sesuai Flowchart: Validasi Login)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect sesuai Role (Flowchart Admin vs Siswa)
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/siswa/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->withInput($request->only('username'));
    }

    /**
     * Menampilkan form daftar (Sesuai Flowchart: Daftar Anggota)
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses Registrasi Anggota Baru
     */
    public function register(Request $request)
    {
        $request->validate([
            'username'     => 'required|unique:users,username',
            'password'     => 'required|min:6',
            'nama_lengkap' => 'required'
        ]);

        User::create([
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'role'         => 'siswa' // Default role saat mendaftar
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar, silakan login!');
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}