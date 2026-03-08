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
        Schema::create('absen_gurus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jadwal_kerja_id')->constrained('jadwal_kerjas')->cascadeOnDelete();

            $table->date('tanggal');

            $table->enum('status', [
                'hadir',
                'izin',
                'sakit',
                'alpha',
                'terlambat'
            ]);

            $table->time('jam_masuk');
            $table->time('jam_keluar')->nullable();

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique(['jadwal_kerja_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen_gurus');
    }
};
