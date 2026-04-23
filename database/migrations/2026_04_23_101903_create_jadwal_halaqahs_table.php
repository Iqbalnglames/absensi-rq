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
        Schema::create('jadwal_halaqahs', function (Blueprint $table) {
            $table->id();
            $table->enum('hari', ['senin','selasa','rabu','kamis','jumat','sabtu']);
            $table->foreignId('halaqah_id')->constrained('halaqahs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_halaqahs');
    }
};
