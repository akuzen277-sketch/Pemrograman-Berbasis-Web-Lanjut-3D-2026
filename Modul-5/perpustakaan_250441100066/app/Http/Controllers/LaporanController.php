<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Menampilkan halaman laporan perpustakaan
    public function index()
    {
        abort_unless(
            auth()->user()->can('lihat laporan perpustakaan'),
            403,
            'Anda tidak memiliki hak akses untuk melihat laporan perpustakaan.'
        );

        $totalBuku = Buku::count();
        $totalKategori = Kategori::count();
        $totalPeminjaman = Peminjaman::count();
        $peminjamanMenunggu = Peminjaman::where('status', 'menunggu')->count();
        $peminjamanDisetujui = Peminjaman::where('status', 'disetujui')->count();
        $peminjamanDitolak = Peminjaman::where('status', 'ditolak')->count();
        $peminjamanDikembalikan = Peminjaman::where('status', 'dikembalikan')->count();

        // Rekap Buku per Kategori
        $bukuPerKategori = Kategori::withCount('bukus')->get();

        // Rekap Peminjaman per Buku
        $peminjamanPerBuku = Buku::withCount('peminjamans')
            ->orderByDesc('peminjamans_count')
            ->take(10)
            ->get();

        // Riwayat peminjaman terbaru
        $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->take(10)
            ->get();

        return view('laporan.index', compact(
            'totalBuku',
            'totalKategori',
            'totalPeminjaman',
            'peminjamanMenunggu',
            'peminjamanDisetujui',
            'peminjamanDitolak',
            'peminjamanDikembalikan',
            'bukuPerKategori',
            'peminjamanPerBuku',
            'peminjamanTerbaru'
        ));
    }
}
