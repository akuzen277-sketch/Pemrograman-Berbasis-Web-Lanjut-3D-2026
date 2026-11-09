<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        $user = Auth::user();

        abort_unless(
            $user->can('melihat riwayat peminjaman sendiri') || $user->can('kelola peminjaman'),
            403,
            'Anda tidak memiliki izin untuk melihat data peminjaman.'
        );

        if ($user->hasRole('siswa') || $user->hasRole('anggota')) {

            $anggota = $user->anggota;

            abort_if(!$anggota, 403, 'Data anggota belum terhubung ke akun Anda.');

            // Siswa HANYA dapat melihat data peminjaman miliknya sendiri
            $peminjamans = Peminjaman::with(['anggota', 'buku'])
                ->where('anggota_id', $anggota->id)
                ->latest()
                ->get();

        } elseif ($user->hasAnyRole(['admin', 'petugas']) || $user->can('kelola peminjaman')) {

            // Admin dan Petugas dapat melihat semua pengajuan peminjaman
            $peminjamans = Peminjaman::with(['anggota', 'buku'])
                ->whereHas('anggota', function ($query) {
                    $query->whereNotNull('user_id');
                })
                ->latest()
                ->get();

        } else {
            abort(403, 'Akses ditolak.');
        }

        return view('peminjaman.index', compact('peminjamans'));
    }

    // Menampilkan form pengajuan (Khusus Siswa yang memiliki hak mengajukan)
    public function create()
    {
        $user = Auth::user();

        abort_unless(
            $user->can('mengajukan peminjaman buku'),
            403,
            'Anda tidak memiliki izin untuk mengajukan peminjaman buku.'
        );

        abort_unless(
            $user->hasRole('siswa') || $user->hasRole('anggota') || $user->anggota,
            403,
            'Hanya akun siswa/anggota yang dapat mengajukan peminjaman buku.'
        );

        $bukus = Buku::all();

        return view('peminjaman.create', compact('bukus'));
    }

    // Menyimpan pengajuan peminjaman
    public function store(Request $request)
    {
        $user = Auth::user();

        abort_unless(
            $user->can('mengajukan peminjaman buku'),
            403,
            'Anda tidak memiliki izin untuk mengajukan peminjaman buku.'
        );

        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
        ]);

        $anggota = $user->anggota;

        abort_if(!$anggota, 403, 'Data anggota belum terhubung ke akun Anda.');

        Peminjaman::create([
            'anggota_id' => $anggota->id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => now()->toDateString(),
            'status' => 'menunggu',
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dibuat.');
    }

    // Menyetujui atau menolak pengajuan (Khusus Admin & Petugas yang berwenang)
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $user = Auth::user();

        abort_unless(
            $user->hasAnyRole(['admin', 'petugas']) && $user->can('memproses persetujuan peminjaman'),
            403,
            'Anda tidak memiliki izin untuk memproses persetujuan peminjaman.'
        );

        abort_unless($peminjaman->status === 'menunggu', 403, 'Pengajuan peminjaman ini sudah diproses sebelumnya.');

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'tanggal_kembali' => [
                'required_if:status,disetujui',
                'nullable',
                'date',
                'after_or_equal:today',
            ],
        ]);

        $peminjaman->update([
            'status' => $request->status,
            'tanggal_kembali' => $request->status === 'disetujui'
                ? $request->tanggal_kembali
                : null,
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil diproses.');
    }

    // Mencatat pengembalian buku (Khusus Admin & Petugas yang berwenang)
    public function returnBook(Peminjaman $peminjaman)
    {
        $user = Auth::user();

        abort_unless(
            $user->hasAnyRole(['admin', 'petugas']) && $user->can('mencatat pengembalian buku'),
            403,
            'Anda tidak memiliki izin untuk mencatat pengembalian buku.'
        );

        abort_unless($peminjaman->status === 'disetujui', 403, 'Hanya peminjaman berstatus disetujui yang dapat dikembalikan.');

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return back()->with('success', 'Pengembalian buku berhasil dicatat.');
    }
}
