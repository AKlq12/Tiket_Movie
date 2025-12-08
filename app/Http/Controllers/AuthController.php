<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Arahkan user ke Keycloak
    public function redirect() {
        return Socialite::driver('keycloak')
            ->scopes(['openid']) 
            ->redirect();
    }

    // 2. Terima balikan dari Keycloak
    public function callback() {
        try {
            $userKeycloak = Socialite::driver('keycloak')->user();
            
            // --- 1. AMBIL DATA USER DARI HASIL DUMP TADI ---
            // Kita pakai property ->user langsung karena sudah terbukti isinya benar
            $attributes = $userKeycloak->user;
            
            $roles = $attributes['realm_access']['roles'] ?? [];
            
            // --- 2. TENTUKAN ROLE ---
            $userRole = 'user'; // Default
            
            // Cek apakah ada tulisan 'admin' atau 'manager' di dalam array roles
            if (in_array('admin', $roles)) {
                $userRole = 'admin';
            } elseif (in_array('manager', $roles)) {
                $userRole = 'manager';
            }
            
            // --- 3. AMBIL ID TOKEN (Untuk Logout) ---
            $idToken = $userKeycloak->accessTokenResponseBody['id_token'] ?? null;
            session(['keycloak_id_token' => $idToken]);

            // --- 4. SIMPAN KE DATABASE ---
            // Fungsi ini akan UPDATE role user jika emailnya sudah ada
            $user = User::updateOrCreate([
                'email' => $userKeycloak->email,
            ], [
                'keycloak_id' => $userKeycloak->id,
                'name' => $userKeycloak->name,
                'role' => $userRole, // Role baru dari Keycloak akan tersimpan disini
            ]);

            Auth::login($user);

            // --- 5. AUTO REDIRECT (PENTING) ---
            if ($user->role === 'admin') {
                return redirect()->route('films.index');
            } elseif ($user->role === 'manager') {
                return redirect()->route('manager.dashboard');
            }
            
            return redirect('/'); 

        } catch (\Exception $e) {
            return "Gagal Login: " . $e->getMessage();
        }
    }

    // 3. Logout
    public function logout() {
        $idToken = session('keycloak_id_token');
        
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $logoutUrl = env('KEYCLOAK_BASE_URL') . '/realms/' . env('KEYCLOAK_REALM') . '/protocol/openid-connect/logout';

        if ($idToken) {
            $query = http_build_query([
                'id_token_hint' => $idToken,
                'post_logout_redirect_uri' => url('/'),
            ]);
            return redirect($logoutUrl . '?' . $query);
        }

        $query = http_build_query([
            'client_id' => env('KEYCLOAK_CLIENT_ID'),
            'post_logout_redirect_uri' => url('/'),
        ]);
        
        return redirect($logoutUrl . '?' . $query);
    }
}