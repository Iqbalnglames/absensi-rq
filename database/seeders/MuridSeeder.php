<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Murid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MuridSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasList = Kelas::all();

        foreach ($kelasList as $kelas) {
            for ($i = 1; $i <= 10; $i++) {
                Murid::create([
                    'nama' => 'Santri '.$kelas->nama.'-'.$i,
                    'kelas_id' => $kelas->id,
                    'alamat' => "Madiun",
                ]);
            }
        }
    }
}
