<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->can('akses dashboard admin') || $user->hasRole('admin')) {
            $totalBuku = Buku::count();
            $totalPengguna = User::count();
            $totalPeminjaman = Peminjaman::count();
            $peminjamanMenunggu = Peminjaman::where('status', 'menunggu')->count();

            return view('dashboard.admin', compact(
                'totalBuku',
                'totalPengguna',
                'totalPeminjaman',
                'peminjamanMenunggu'
            ));
        }

        if ($user->can('akses dashboard petugas') || $user->hasRole('petugas')) {
            return view('dashboard.petugas');
        }

        if ($user->hasRole('siswa') || $user->hasRole('anggota')) {
            return view('dashboard.siswa');
        }

        abort(403, 'Anda tidak memiliki hak akses ke dashboard.');
    }
}
