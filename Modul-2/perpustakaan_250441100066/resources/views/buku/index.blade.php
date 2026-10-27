@extends('layouts.main')
@section('content')
    <h2>Daftar Buku</h2>
    @foreach($books as $buku)
        <x-book-card :judul="$buku['judul']" :penulis="$buku['penulis']" :tahunTerbit="$buku['tahun_terbit']">
            <a href="{{ url('/buku/' . $buku['id']) }}">Lihat Detail</a>
        </x-book-card>
    @endforeach
@endsection