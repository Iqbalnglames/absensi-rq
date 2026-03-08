<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $guruRole  = Role::where('name', 'guru')->first();

        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password')
        ]);
        $admin->roles()->attach($adminRole);

        for ($i = 1; $i <= 3; $i++) {
            $guru = User::create([
                'name' => 'Guru '.$i,
                'username' => 'guru '.$i,
                'email' => 'guru'.$i.'@mail.com',
                'password' => Hash::make('password')
            ]);
            $guru->roles()->attach($guruRole);
        }
    }
}
