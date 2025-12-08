<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'film_id',
        'start_time',
        'price',
    ];

    // Relasi ke Film (Sudah ada sebelumnya)
    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    // --- TAMBAHAN BARU (PENTING) ---
    // Satu Jadwal punya BANYAK Kursi
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}