<?php

namespace App\Http\Controllers;

class BukuController extends Controller
{
    // Data buku sementara (tanpa database)
    private function dataBuku()
    {
        return [
            ['id' => 1, 'judul' => 'Laskar Pelangi',       'penulis' => 'Andrea Hirata',         'tahun' => 2005, 'kategori' => 'Novel'],
            ['id' => 2, 'judul' => 'Bumi Manusia',         'penulis' => 'Pramoedya Ananta Toer', 'tahun' => 1980, 'kategori' => 'Sejarah'],
            ['id' => 3, 'judul' => 'Filosofi Teras',       'penulis' => 'Henry Manampiring',     'tahun' => 2018, 'kategori' => 'Pengembangan Diri'],
            ['id' => 4, 'judul' => 'Dilan 1990',           'penulis' => 'Pidi Baiq',             'tahun' => 2014, 'kategori' => 'Romansa'],
            ['id' => 5, 'judul' => 'Sapiens',              'penulis' => 'Yuval Noah Harari',     'tahun' => 2011, 'kategori' => 'Sains'],
        ];
    }

    // Halaman Daftar Buku
    public function index()
    {
        $bukus = $this->dataBuku();
        return view('buku.index', compact('bukus'));
    }

    // Halaman Detail Buku
    public function show($id)
    {
        // Cari buku yang id-nya sama dengan {id} di URL
        $buku = collect($this->dataBuku())->firstWhere('id', $id);

        return view('buku.show', compact('buku'));
    }
}