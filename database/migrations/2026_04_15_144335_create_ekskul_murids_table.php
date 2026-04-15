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
        Schema::create('ekskul_murids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('murid_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ekskul_id')->constrained()->cascadeOnDelete();

            $table->unique(['murid_id', 'ekskul_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ekskul_murids');
    }
};
