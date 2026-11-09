<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Akses rute khusus role
Route::middleware(['auth', 'permission:akses dashboard admin'])->group(function () {
    Route::get('/admin', function () {
        return redirect()->route('dashboard');
    });
});

Route::middleware(['auth', 'permission:akses dashboard petugas'])->group(function () {
    Route::get('/petugas', function () {
        return redirect()->route('dashboard');
    });
});

Route::middleware(['auth', 'role:siswa|anggota'])->group(function () {
    Route::get('/siswa', function () {
        return redirect()->route('dashboard');
    });
});

Route::middleware(['auth'])->group(function () {

    // Melihat buku (Admin, Petugas, Siswa)
    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:view buku')
        ->name('buku.index');

    // Menambah buku (Admin, Petugas)
    Route::post('/buku', [BukuController::class, 'store'])
        ->middleware('permission:create buku')
        ->name('buku.store');

    // Mengedit buku (Admin, Petugas)
    Route::put('/buku/{buku}', [BukuController::class, 'update'])
        ->middleware('permission:edit buku')
        ->name('buku.update');

    // Menghapus buku (Admin, Petugas)
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
        ->middleware('permission:delete buku')
        ->name('buku.destroy');

});

Route::middleware(['auth'])->group(function () {

    // Melihat daftar peminjaman (Siswa riwayat sendiri, Admin/Petugas kelola semua)
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->middleware('permission:melihat riwayat peminjaman sendiri|kelola peminjaman')
        ->name('peminjaman.index');

    // Siswa mengajukan peminjaman (Hanya role dengan 'mengajukan peminjaman buku')
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])
        ->middleware('permission:mengajukan peminjaman buku')
        ->name('peminjaman.create');

    Route::post('/peminjaman', [PeminjamanController::class, 'store'])
        ->middleware('permission:mengajukan peminjaman buku')
        ->name('peminjaman.store');

    // Admin dan petugas memproses persetujuan (Hanya role dengan 'memproses persetujuan peminjaman')
    Route::patch('/peminjaman/{peminjaman}', [PeminjamanController::class, 'update'])
        ->middleware('permission:memproses persetujuan peminjaman')
        ->name('peminjaman.update');

    // Admin dan petugas mencatat pengembalian (Hanya role dengan 'mencatat pengembalian buku')
    Route::patch('/peminjaman/{peminjaman}/kembali', [PeminjamanController::class, 'returnBook'])
        ->middleware('permission:mencatat pengembalian buku')
        ->name('peminjaman.return');

    // Kelola Data Pengguna & Role Pengguna (Hanya Admin / permission kelola data/role pengguna)
    Route::get('/users', [UserController::class, 'index'])
        ->middleware('permission:kelola data pengguna|kelola role pengguna')
        ->name('users.index');

    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
        ->middleware('permission:kelola role pengguna')
        ->name('users.updateRole');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('permission:kelola data pengguna')
        ->name('users.destroy');

    // Laporan Perpustakaan (Hanya Admin & Petugas / permission 'lihat laporan perpustakaan')
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat laporan perpustakaan')
        ->name('laporan.index');

});
require __DIR__.'/auth.php';
