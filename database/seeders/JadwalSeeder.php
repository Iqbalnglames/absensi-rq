<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\User;
use App\Models\Mapel;
use App\Models\JamPelajaran;
use App\Models\Jadwal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = User::whereHas('roles', fn($q) => $q->where('name','guru'))->get();
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        $jam   = JamPelajaran::all();

        foreach ($gurus as $guru) {
            for ($i = 0; $i < 3; $i++) {
                $jadwal = Jadwal::create([
                    'user_id' => $guru->id,
                    'kelas_id' => $kelas->random()->id,
                    'mapel_id' => $mapel->random()->id,
                    'hari' => ['senin','selasa','rabu','kamis','jumat'][rand(0,4)]
                ]);
                
                $jadwal->jam_pelajaran()->attach($jam->random()->id);
            }
        }
    }
}
