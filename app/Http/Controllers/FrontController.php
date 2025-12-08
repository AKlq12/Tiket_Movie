<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    // Halaman Depan (Daftar Film)
    public function index()
    {
        $films = Film::all();
        return view('welcome', compact('films'));
    }

    // Halaman Detail Film & Jadwal
    public function show($id)
    {
        // Ambil film beserta jadwalnya
        $film = Film::with(['schedules' => function($query) {
            $query->where('start_time', '>', now())->orderBy('start_time');
        }])->findOrFail($id);

        return view('frontend.show', compact('film'));
    }
}