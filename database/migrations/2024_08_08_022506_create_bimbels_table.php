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
        Schema::create('bimbels', function (Blueprint $table) {
            $table->id();
            $table->string('title', 500);
            $table->longText('description')->nullable();
            $table->float('harga')->default(0);
            $table->string('day_start'); // Hari awal (misal: Senin)
            $table->string('day_end');   // Hari akhir (misal: Jumat)
            $table->time('time_start');  // Waktu mulai (misal: 08:00)
            $table->time('time_end');    // Waktu berakhir (misal: 10:00)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbels');
    }
};
