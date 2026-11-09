
@extends('layouts.main')

@section('title', 'Dashboard Petugas')

@section('content')

<div class="page-heading">
    <h1>Dashboard Petugas 👋</h1>
    <p>Selamat datang, {{ auth()->user()->name }}. Kelola koleksi buku perpustakaan.</p>
</div>

<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-icon">📚</div>
        <p>Pengelolaan</p>
        <h2>Data Buku</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">➕</div>
        <p>Fitur</p>
        <h2>Tambah Buku</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">✏️</div>
        <p>Fitur</p>
        <h2>Ubah Buku</h2>
    </div>

</div>

<div class="content-card">
    <h3>Panel Petugas</h3>
    <p>Anda dapat melihat, menambahkan, dan mengubah data buku sesuai hak akses.</p>

    <br>

    <a href="{{ route('buku.index') }}" class="btn-primary">
        Kelola Data Buku →
    </a>
</div>
<div class="content-card">
    <div class="stat-icon">
        📚
    </div>

    <h3>Pengajuan Peminjaman</h3>

    <p>
        Lihat dan kelola pengajuan peminjaman buku
        yang diajukan oleh siswa.
    </p>

    <a href="{{ route('peminjaman.index') }}" class="btn-primary">
        Lihat Pengajuan
    </a>
</div>

@endsection
