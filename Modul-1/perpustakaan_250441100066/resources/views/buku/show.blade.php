@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
    @if ($buku)
        <h2>Detail Buku</h2>

        <div class="detail">
            <p><strong>ID Buku:</strong> {{ $buku['id'] }}</p>
            <p><strong>Judul:</strong> {{ $buku['judul'] }}</p>
            <p><strong>Penulis:</strong> {{ $buku['penulis'] }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $buku['tahun'] }}</p>
            <p><strong>Kategori:</strong> {{ $buku['kategori'] }}</p>
        </div>
    @else
        <div class="not-found">
            <h2>Buku tidak ditemukan 😕</h2>
            <p>Buku yang kamu cari tidak ada dalam daftar.</p>
        </div>
    @endif

    <a href="{{ route('buku.index') }}" class="btn">← Kembali ke Daftar Buku</a>
@endsection