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
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->string('user_name'); // Siapa pelakunya
        $table->string('action');    // Apa yang dilakukan (misal: "Beli Tiket")
        $table->text('description'); // Detail (misal: "Film A, Kursi B1")
        $table->timestamps();        // Kapan kejadiannya
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
