@extends('layouts.main')
@section('content')
    @if($buku)
        <h2>Detail Buku</h2>
        <x-book-card :judul="$buku['judul']" :penulis="$buku['penulis']" :tahunTerbit="$buku['tahun_terbit']" :kategori="$buku['kategori']">
            <a href="{{ route('buku.index') }}">Kembali ke Daftar Buku</a>
        </x-book-card>
    @else
        <h2>Data buku tidak ditemukan.</h2>
        <a href="{{ route('buku.index') }}">Kembali</a>
    @endif
@endsection