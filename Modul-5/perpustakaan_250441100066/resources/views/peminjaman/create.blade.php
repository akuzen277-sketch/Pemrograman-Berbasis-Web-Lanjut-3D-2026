@extends('layouts.main')

@section('title', 'Ajukan Peminjaman')

@section('content')

<div class="page-heading">
    <h1>Ajukan Peminjaman 📚</h1>
    <p>Silakan pilih buku yang ingin kamu pinjam dari perpustakaan.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📖</div>
        <p>Menu</p>
        <h2>Pilih Buku</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <p>Status Awal</p>
        <h2>Menunggu</h2>
    </div>
</div>

<div class="content-card">
    <h3>Formulir Peminjaman Buku</h3>
    <p>Lengkapi formulir berikut untuk mengajukan peminjaman.</p>

    <br>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Pengajuan belum berhasil.</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="buku_id" class="form-label fw-semibold">
                Pilih Buku
            </label>

            <select name="buku_id" id="buku_id"
                    class="form-select" required>
                <option value="">-- Pilih Buku --</option>

                @foreach ($bukus as $buku)
                    <option value="{{ $buku->id }}"
                        {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                        {{ $buku->judul }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="alert alert-info">
            <strong>Informasi:</strong>
            Pengajuan peminjaman akan berstatus menunggu sampai Admin atau Petugas memprosesnya.
        </div>
        <br>
        <div class="d-flex flex-wrap gap-2">
            <button type="submit" class="btn-primary">
                Ajukan Peminjaman →
            </button>

            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                Kembali ke Dashboard
            </a>
        </div>
    </form>
</div>

@endsection