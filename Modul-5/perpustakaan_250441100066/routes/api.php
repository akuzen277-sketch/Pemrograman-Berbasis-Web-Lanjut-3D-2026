<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;

// API Rekap - Dilindungi autentikasi dan permission 'lihat laporan perpustakaan'
Route::middleware(['auth:sanctum', 'permission:lihat laporan perpustakaan'])->group(function () {
    Route::get('rekap/buku-per-kategori', [RekapController::class, 'bukuPerKategori']);
    Route::get('rekap/peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);
});

// API Buku dengan autentikasi dan permission
Route::middleware(['auth:sanctum'])->group(function () {

    // Menampilkan semua buku (Hanya role dengan 'view buku': Admin, Petugas, Siswa)
    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:view buku');

    // Menampilkan detail buku
    Route::get('/buku/{buku}', [BukuController::class, 'show'])
        ->middleware('permission:view buku');

    // Menambah buku (Hanya role dengan 'create buku': Admin, Petugas)
    Route::post('/buku', [BukuController::class, 'store'])
        ->middleware('permission:create buku');

    // Mengubah buku (Hanya role dengan 'edit buku': Admin, Petugas)
    Route::put('/buku/{buku}', [BukuController::class, 'update'])
        ->middleware('permission:edit buku');

    // Menghapus buku (Hanya role dengan 'delete buku': Admin, Petugas)
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])
        ->middleware('permission:delete buku');

});
