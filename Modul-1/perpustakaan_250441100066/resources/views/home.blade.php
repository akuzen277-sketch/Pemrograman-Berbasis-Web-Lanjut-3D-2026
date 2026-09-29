@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2>Selamat Datang di Perpustakaan Digital</h2>
    <p>Aplikasi ini menampilkan koleksi buku yang tersedia. Silakan lihat daftar buku untuk mulai menjelajah.</p>
    <a href="{{ route('buku.index') }}" class="btn">Lihat Daftar Buku</a>
@endsection