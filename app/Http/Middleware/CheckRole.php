<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // ❌ Jika belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        //  Jika role tidak sesuai
        if (!in_array($user->role, $roles)) {

            //  Redirect sesuai role (biar UX bagus, bukan langsung 403)
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            if ($user->role === 'siswa') {
                return redirect('/siswa/dashboard');
            }

            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang.');
        }

        return $next($request);
    }
}