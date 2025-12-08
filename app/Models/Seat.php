<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    // --- TAMBAHAN PENTING (Agar tidak MassAssignmentException) ---
    protected $fillable = [
        'schedule_id',
        'seat_number',
        'status',
        'user_id'
    ];

    // Relasi ke Jadwal
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}