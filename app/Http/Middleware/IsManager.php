<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsManager
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah role user adalah 'manager' (sesuai Keycloak tadi)
        if (Auth::check() && Auth::user()->role === 'manager') {
            return $next($request);
        }

        // Jika bukan manager, tendang keluar
        return redirect('/')->with('error', 'Khusus Manager!');
    }
}