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
        Schema::create('jam_jadwal_halaqahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_halaqah_id')->constrained('jadwal_halaqahs')->cascadeOnDelete();
            $table->foreignId('jam_halaqah_id')->constrained('jam_halaqahs')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['jadwal_halaqah_id','jam_halaqah_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_jadwal_halaqahs');
    }
};
