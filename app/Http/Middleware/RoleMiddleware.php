<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect('/login')->withErrors(['error' => 'Silakan login terlebih dahulu untuk mengakses halaman ini.']);
        }

        // Cek apakah role user ada dalam daftar role yang diizinkan
        $userRole = auth()->user()->role;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Log user yang mencoba mengakses halaman tanpa izin
        Log::warning('Akses ditolak:', [
            'user_id' => auth()->id(),
            'role' => $userRole,
            'required_roles' => $roles,
            'url' => $request->url(),
        ]);

        return redirect('/')->withErrors([
            'error' => 'Anda tidak memiliki akses ke halaman ini. Halaman ini hanya untuk role: ' . implode(', ', $roles),
        ]);
    }
}
