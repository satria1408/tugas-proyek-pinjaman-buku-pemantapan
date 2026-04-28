<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * ================= LOGIN VIEW =================
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * ================= LOGIN (ADMIN + SISWA) =================
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 🔥 redirect berdasarkan role
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->withInput($request->only('username'));
    }

    /**
     * ================= GOOGLE LOGIN =================
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // 🔥 FIX ERROR STATE
            $googleUser = Socialite::driver('google')->stateless()->user();

            // 🔍 cari user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // 🆕 buat user baru
                $user = User::create([
                    'username' => null,
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make('random123'),
                    'nama_lengkap' => $googleUser->getName(),
                    'alamat' => null,
                    'role' => 'siswa',
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId()
                ]);
            }

            Auth::login($user);

            // 🔥 redirect ke dashboard global
            return redirect('/dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login Google gagal!');
        }
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
            'email'        => null,
            'password'     => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'alamat'       => null,
            'role'         => 'siswa',
            'provider'     => null,
            'provider_id'  => null
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar!');
    }

    /**
     * ================= LOGOUT =================
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}