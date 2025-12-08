<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // --- DAFTAR KOLOM YANG BOLEH DIISI ---
    protected $fillable = [
        'user_id',
        'schedule_id',
        'seat_id',
        'booking_time',
        'payment_status',
    ];

    // Relasi (Opsional, tapi bagus untuk nanti)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}