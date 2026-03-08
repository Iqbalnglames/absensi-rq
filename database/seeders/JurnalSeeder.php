<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use App\Models\Jurnal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurnalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jadwals = Jadwal::all();

        foreach ($jadwals as $jadwal) {
            for ($i = 1; $i <= 5; $i++) {
                Jurnal::create([
                    'jadwal_mengajar_id' => $jadwal->id,
                    'tanggal' => now()->subDays(rand(1,30)),
                    'bab' => 'Aljabar '.$i,
                    'materi' => 'Materi pertemuan '.$i,
                    'catatan' => 'Pembelajaran berjalan lancar'
                ]);
            }
        }
    }
}
