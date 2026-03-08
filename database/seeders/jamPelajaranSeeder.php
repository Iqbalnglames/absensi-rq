<?php

namespace Database\Seeders;

use App\Models\JamPelajaran;
use App\Models\Jenjang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class jamPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $smp = Jenjang::where('nama_jenjang', 'MSW')->first();
        $sma = Jenjang::where('nama_jenjang', 'MA')->first();

        /*
        |--------------------------------------------------------------------------
        | JAM SMP (40 menit)
        |--------------------------------------------------------------------------
        */

        $start = strtotime('07:00');
        $durasi = 35;

        for ($i = 1; $i <= 6; $i++) {
            $mulai = date('H:i:s', $start);
            $selesai = date('H:i:s', strtotime("+$durasi minutes", $start));

            JamPelajaran::create([
                'jam_ke' => $i,
                'jenjang_id' => $smp->id,
                'jam_mulai' => $mulai,
                'jam_selesai' => $selesai,
            ]);

            $start = strtotime("+$durasi minutes", $start);

            // Istirahat setelah jam ke-3
            if ($i == 3) {
                $start = strtotime("+15 minutes", $start);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | JAM SMA (45 menit)
        |--------------------------------------------------------------------------
        */

        $start = strtotime('07:00');
        $durasi = 45;

        for ($i = 1; $i <= 6; $i++) {
            $mulai = date('H:i:s', $start);
            $selesai = date('H:i:s', strtotime("+$durasi minutes", $start));

            JamPelajaran::create([
                'jam_ke' => $i,
                'jenjang_id' => $sma->id,
                'jam_mulai' => $mulai,
                'jam_selesai' => $selesai,
            ]);

            $start = strtotime("+$durasi minutes", $start);

            // Istirahat setelah jam ke-3
            if ($i == 3) {
                $start = strtotime("+15 minutes", $start);
            }
        }
    }
}
