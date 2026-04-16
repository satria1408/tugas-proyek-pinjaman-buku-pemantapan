<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ❌ Jika admin login di sini → tolak
            if (Auth::user()->role === 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Silakan login melalui halaman admin!'
                ]);
            }

            return redirect()->intended('/siswa/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->withInput($request->only('username'));
    }

    /**
     * ================= LOGIN ADMIN =================
     */
    public function showAdminLogin()
    {
        return view('auth.login');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ❌ Jika bukan admin → tolak
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Akun ini bukan admin!'
                ]);
            }

            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ]);
    }

    /**
     * ================= REGISTER =================
     */
    public function showRegister()
    {
        return view('auth.register');
    }

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
            'role'         => 'siswa' // default user
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar, silakan login!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}