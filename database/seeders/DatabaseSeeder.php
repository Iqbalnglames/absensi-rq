<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            JenjangSeeder::class,
            KelasSeeder::class,
            MapelSeeder::class,
            JamPelajaranSeeder::class,
            MuridSeeder::class,
            JadwalSeeder::class,
            JurnalSeeder::class,
            AbsenSeeder::class,
    ]);
    }
}
