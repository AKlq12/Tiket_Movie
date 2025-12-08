<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    // 1. Tampilkan Daftar Film
    public function index()
    {
        $films = Film::all();
        return view('films.index', compact('films'));
    }

    // 2. Tampilkan Form Tambah Film
    public function create()
    {
        return view('films.create');
    }

    // 3. Simpan Data ke Database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'duration_minutes' => 'required|integer',
            'poster_url' => 'required|url', // Harus format URL gambar
        ]);

        // Simpan
        Film::create($request->all());

        return redirect()->route('films.index')->with('success', 'Film berhasil ditambahkan!');
    }
    
    // Nanti kita tambahkan edit/delete disini
}