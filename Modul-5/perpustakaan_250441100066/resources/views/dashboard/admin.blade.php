@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')

<div class="page-heading">
    <h1>Dashboard Admin 👋</h1>
    <p>Selamat datang, {{ auth()->user()->name }}. Kelola seluruh sistem perpustakaan di sini.</p>
</div>

<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-icon">📚</div>
        <p>Total Buku</p>
        <h2>{{ $totalBuku ?? \App\Models\Buku::count() }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <p>Total Pengguna</p>
        <h2>{{ $totalPengguna ?? \App\Models\User::count() }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <p>Menunggu Persetujuan</p>
        <h2>{{ $peminjamanMenunggu ?? \App\Models\Peminjaman::where('status', 'menunggu')->count() }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <p>Total Peminjaman</p>
        <h2>{{ $totalPeminjaman ?? \App\Models\Peminjaman::count() }}</h2>
    </div>

</div>

<div class="content-card mb-4">
    <div class="stat-icon">📚</div>
    <h3>Kelola Data Buku</h3>
    <p>Lihat katalog buku, tambahkan buku baru, perbarui data, atau hapus buku dari sistem perpustakaan.</p>
    <br>
    <a href="{{ route('buku.index') }}" class="btn-primary">
        Kelola Data Buku →
    </a>
</div>

<div class="content-card mb-4">
    <div class="stat-icon">📋</div>
    <h3>Kelola Pengajuan Peminjaman</h3>
    <p>Tinjau pengajuan peminjaman siswa yang berstatus menunggu, setujui/tolak permohonan, serta catat pengembalian buku.</p>
    <br>
    <a href="{{ route('peminjaman.index') }}" class="btn-primary">
        Kelola Peminjaman Buku →
    </a>
</div>

<div class="content-card mb-4">
    <div class="stat-icon">👥</div>
    <h3>Manajemen Pengguna & Role</h3>
    <p>Kelola data seluruh akun pengguna yang terdaftar di perpustakaan serta atur pembagian hak akses (role) pengguna.</p>
    <br>
    <a href="{{ route('users.index') }}" class="btn-primary">
        Kelola Pengguna & Hak Akses →
    </a>
</div>

<div class="content-card mb-4">
    <div class="stat-icon">📊</div>
    <h3>Laporan & Rekap Perpustakaan</h3>
    <p>Pantau laporan lengkap rekap buku per kategori, buku yang paling sering dipinjam, dan rekap statistik peminjaman.</p>
    <br>
    <a href="{{ route('laporan.index') }}" class="btn-primary">
        Lihat Laporan Perpustakaan →
    </a>
</div>

@endsection
