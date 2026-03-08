<?php

namespace Database\Seeders;

use App\Models\Jenjang;
use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $smp = Jenjang::where('nama_jenjang', 'MSW')->first();
        $sma = Jenjang::where('nama_jenjang', 'MA')->first();

        // ===== SMP =====
        foreach (['7A','8A','9A'] as $kelas) {
            Kelas::create([
                'nama_kelas' => $kelas,
                'jenjang_id' => $smp->id,
            ]);
        }

        // ===== SMA =====
        foreach (['10','11','12'] as $kelas) {
            Kelas::create([
                'nama_kelas' => $kelas,
                'jenjang_id' => $sma->id,
            ]);
        }
    }
}
