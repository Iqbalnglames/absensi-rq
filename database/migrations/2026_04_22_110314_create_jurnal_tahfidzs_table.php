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
        Schema::create('jurnal_tahfidzs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jam_halaqah_id')->constrained('jam_halaqahs')->cascadeOnDelete();
            $table->date('tanggal');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_tahfidzs');
    }
};
