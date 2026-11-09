<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
            ]
        );

        $admin->assignRole('admin');

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@gmail.com'],
            [
                'name' => 'Petugas',
                'password' => Hash::make('password123'),
            ]
        );

        $petugas->assignRole('petugas');

        $anggota = User::firstOrCreate(
            ['email' => 'siswa@gmail.com'],
            [
                'name' => 'Anggota',
                'password' => Hash::make('password123'),
            ]
        );

        $anggota->assignRole('anggota');
    }
}