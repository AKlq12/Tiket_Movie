<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TicketController; // <--- 1. JANGAN LUPA INI DITAMBAHKAN

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. BAGIAN PUBLIK (Bisa diakses siapa saja)
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/movie/{id}', [FrontController::class, 'show'])->name('movie.show');


// 2. BAGIAN AUTH (Login/Logout Keycloak)
Route::get('/login', [AuthController::class, 'redirect'])->name('login');
Route::get('/auth/callback', [AuthController::class, 'callback']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// 3. BAGIAN ADMIN (Hanya User dengan Role ADMIN/MANAGER)
Route::middleware(['auth', 'admin_access'])->group(function () {
    Route::resource('films', FilmController::class);
    Route::resource('schedules', ScheduleController::class);

    Route::get('/dashboard', function () {
        return redirect('/'); 
    });
});


// 4. BAGIAN USER BIASA (Booking & Tiket) - Syaratnya Cuma Login ('auth')
Route::middleware(['auth'])->group(function () {
    // Halaman Pilih Kursi
    Route::get('/booking/{schedule}', [BookingController::class, 'create'])->name('booking.create');
    
    // Proses Simpan ke Database
    Route::post('/booking/{schedule}', [BookingController::class, 'store'])->name('booking.store');

    // Halaman Riwayat Tiket (Tiket Saya)
    Route::get('/my-tickets', [TicketController::class, 'index'])->name('tickets.index'); // <--- 2. INI ROUTE BARUNYA
});

// 5. BAGIAN MANAGER (Log & Monitoring)
Route::middleware(['auth', 'manager_access'])->group(function () {
    Route::get('/manager', [App\Http\Controllers\ManagerController::class, 'index'])->name('manager.dashboard');
    Route::get('/manager/export', [App\Http\Controllers\ManagerController::class, 'exportExcel'])->name('manager.export');
});