<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Film;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // 1. Tampilkan Daftar Jadwal
    public function index()
    {
        // Ambil jadwal beserta data film-nya (Eager Loading)
        $schedules = Schedule::with('film')->latest()->get();
        return view('schedules.index', compact('schedules'));
    }

    // 2. Form Tambah Jadwal
    public function create()
    {
        $films = Film::all(); // Kirim data film untuk Dropdown
        return view('schedules.create', compact('films'));
    }

    // 3. Simpan Jadwal
    public function store(Request $request)
    {
        $request->validate([
            'film_id' => 'required|exists:films,id',
            'start_time' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        Schedule::create($request->all());

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dibuat!');
    }
}