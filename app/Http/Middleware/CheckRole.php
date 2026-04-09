<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Jika user belum login atau role user tidak sesuai dengan parameter
        if (!Auth::check() || Auth::user()->role !== $role) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang.');
        }

        return $next($request);
    }
}