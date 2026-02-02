<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class CheckWajibGantiPassword
{
    public function handle(Request $request, Closure $next)
    {

        if (Auth::check() && Auth::user()->wajib_ganti_password == 1) {

            if (!$request->routeIs('ganti_password') && !$request->routeIs('logout')) {
                return redirect()->route('ganti_password')
                    ->with('error', 'Anda wajib mengganti password default demi keamanan.');
            }
        }

        return $next($request);
    }
}
