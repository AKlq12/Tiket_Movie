<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->string('seat_number'); // Contoh: A1, B5
            $table->enum('status', ['available', 'booked'])->default('available');
        
            // Relasi ke User (Siapa yang booking), boleh kosong (nullable)
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->timestamps();

            // Kunci Unik: Satu jadwal TIDAK BOLEH punya dua kursi bernomor sama
            $table->unique(['schedule_id', 'seat_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
