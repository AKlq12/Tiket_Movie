<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek 1: Apakah sudah login?
        // Cek 2: Apakah role-nya admin?
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Silakan masuk
        }

        // Jika bukan admin, tendang ke halaman utama
        return redirect('/')->with('error', 'Anda tidak punya akses Admin!');
    }
}