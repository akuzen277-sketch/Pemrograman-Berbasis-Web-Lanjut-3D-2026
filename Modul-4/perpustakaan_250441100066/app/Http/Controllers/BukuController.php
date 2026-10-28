<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        // Ambil data buku dari database beserta kategorinya
        $books = Buku::with('kategori')->get();

        // Kirim variabel 'books' ke view 'buku.index'
        return view('buku.index', ['books' => $books]);
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->find($id);
        return view('buku.show', compact('buku'));
    }
}