<?php

namespace Database\Seeders;

use App\Models\AbsenMurid;
use App\Models\Jadwal;
use App\Models\Murid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbsenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jadwals = Jadwal::all();

        foreach ($jadwals as $jadwal) {

            $santris = Murid::where('kelas_id', $jadwal->kelas_id)->get();

            foreach ($santris as $santri) {
                AbsenMurid::create([
                    'jadwal_mengajar_id' => $jadwal->id,
                    'murid_id' => $santri->id,
                    'tanggal' => now()->subDays(rand(1,30)),
                    'status' => collect(['hadir','izin','sakit','alpha'])->random()
                ]);
            }
        }
    }
}
