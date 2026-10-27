<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    private $dataBuku = [
        ['id' => 1, 'judul' => 'Pemrograman Web', 'penulis' => 'Budi', 'tahun_terbit' => 2021, 'kategori' => 'Teknologi'],
        ['id' => 2, 'judul' => 'Belajar Laravel', 'penulis' => 'Siti', 'tahun_terbit' => 2022, 'kategori' => 'Teknologi'],
        ['id' => 3, 'judul' => 'Algoritma Pemrograman', 'penulis' => 'Andi', 'tahun_terbit' => 2020, 'kategori' => 'Teknologi'],
        ['id' => 4, 'judul' => 'Basis Data Relasional', 'penulis' => 'Dewi', 'tahun_terbit' => 2019, 'kategori' => 'Teknologi'],
        ['id' => 5, 'judul' => 'Kecerdasan Buatan', 'penulis' => 'Eko', 'tahun_terbit' => 2023, 'kategori' => 'Teknologi'],
    ];

    use App\Models\Buku;

    public function index() {
        $books = Buku::with('kategori')->get();
        return view('buku.index', compact('books'));
    }

    public function show($id) {
        $buku = Buku::with('kategori')->find($id);
        return view('buku.show', compact('buku'));
    }
}