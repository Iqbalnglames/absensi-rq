<?php

namespace Database\Seeders;

use App\Models\Jenjang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jenjang::insert([
            ['nama_jenjang' => 'MSW'],
            ['nama_jenjang' => 'MA'],
        ]);
    }
}
