@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <h2>Daftar Buku</h2>

    <div class="card-list">
        @foreach ($bukus as $buku)
            <x-book-card 
                :judul="$buku['judul']"
                :penulis="$buku['penulis']"
                :tahun="$buku['tahun']"
                :url="route('buku.show', $buku['id'])"
            >
                <span class="badge">{{ $buku['kategori'] }}</span>
            </x-book-card>
        @endforeach
    </div>
@endsection