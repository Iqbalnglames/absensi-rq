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
        Schema::create('absen_ekskuls', function (Blueprint $table) {
           $table->id();
            $table->foreignId('jadwal_ekskul_id')->constrained()->cascadeOnDelete();
            $table->foreignId('murid_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha']);
            $table->date('tanggal');
            $table->timestamps();

            $table->unique(['jadwal_ekskul_id', 'murid_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen_ekskuls');
    }
};
