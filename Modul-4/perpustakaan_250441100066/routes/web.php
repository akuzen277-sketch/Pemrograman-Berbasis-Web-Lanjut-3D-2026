<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController; // <-- Perhatikan ini Web Controller

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/{id}', [BukuController::class, 'show']);