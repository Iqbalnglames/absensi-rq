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
        Schema::create('absen_halaqahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_halaqah_id')->constrained()->cascadeOnDelete();
            $table->foreignId('murid_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha']);
            $table->date('tanggal');

            $table->unique(['jadwal_halaqah_id', 'murid_id', 'tanggal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen_halaqahs');
    }
};
