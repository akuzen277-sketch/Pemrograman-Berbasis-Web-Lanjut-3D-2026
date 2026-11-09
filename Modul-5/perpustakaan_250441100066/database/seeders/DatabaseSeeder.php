<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
    \App\Models\Kategori::factory(3)->create();
    \App\Models\Anggota::factory(3)->create();
    \App\Models\Buku::factory(5)->create();
    \App\Models\Peminjaman::factory(3)->create();
}
}
