<?php

namespace Database\Seeders;

use App\Models\Mapel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Fiqih', 'Tahfidz', 'Bahasa Arab', 'Aqidah'] as $mapel) {
            Mapel::create(['nama_mapel' => $mapel]);
        }
    }
}
