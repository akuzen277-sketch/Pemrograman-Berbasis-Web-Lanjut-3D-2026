<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'anggota_id' => Anggota::factory(),
            'buku_id' => Buku::factory(),
            'tanggal_pinjam' => $this->faker->date(),
            'tanggal_kembali' => $this->faker->date(),
        ];
    }
}
