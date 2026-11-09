
@extends('layouts.main')

@section('title', 'Dashboard Siswa')

@section('content')

<div class="page-heading">
    <h1>Dashboard Siswa 👋</h1>
    <p>Selamat datang, {{ auth()->user()->name }}. Temukan koleksi buku perpustakaan.</p>
</div>

<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-icon">📖</div>
        <p>Menu Utama</p>
        <h2>Koleksi Buku</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🔎</div>
        <p>Fitur</p>
        <h2>Lihat Buku</h2>
    </div>
    

</div>

<div class="content-card">
    <h3>Selamat Datang di Perpustakaan Digital</h3>
    <p>Silakan melihat koleksi buku yang tersedia di perpustakaan.</p>

    <br>

    <a href="{{ route('buku.index') }}" class="btn-primary">
        Lihat Koleksi Buku →
    </a>
</div>


<div class="content-card">
    <h3>Menu Peminjaman Buku 📚</h3>
    <p>Ajukan peminjaman dan pantau status buku yang kamu pinjam.</p>

    <br>

    <a href="{{ route('peminjaman.create') }}" class="btn-primary">
        Ajukan Peminjaman →
    </a>
</div>

<div class="content-card">
    <h3>Lihat Peminjaman Buku 📚</h3>
    <p>Pantau status buku yang kamu pinjam.</p>
    
    <br>

    <a href="{{ route('peminjaman.index') }}" class="btn-primary">
        Lihat Peminjaman →
    </a>
</div>

@endsection
