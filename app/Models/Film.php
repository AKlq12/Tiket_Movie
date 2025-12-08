<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'duration_minutes',
        'poster_url',
    ];

    // --- TAMBAHKAN BAGIAN INI ---
    public function schedules()
    {
        // Satu Film punya BANYAK Jadwal (Has Many)
        return $this->hasMany(Schedule::class);
    }
}