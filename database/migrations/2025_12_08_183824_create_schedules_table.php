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
            Schema::create('schedules', function (Blueprint $table) {
            $table->id();
        // Hapus jadwal jika film dihapus (cascade)
            $table->foreignId('film_id')->constrained('films')->onDelete('cascade');
            $table->dateTime('start_time');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
