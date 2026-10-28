@extends('layouts.main')

@section('content')
<!-- Panggil file CSS eksternal dari public/css/buku.css -->
<link rel="stylesheet" href="{{ asset('css/buku.css') }}">

<h2>Kelola Data Buku (Konsumsi REST API)</h2>

<div id="alert-container"></div>

<!-- Formulir Tambah / Edit Buku -->
<div class="form-card">
    <h3 id="form-title">Tambah Buku Baru</h3>
    <form id="buku-form">
        <input type="hidden" id="buku_id">
        
        <div class="form-group">
            <label class="form-label">Kategori ID:</label>
            <input type="number" id="kategori_id" class="form-input" required>
        </div>
        <div class="form-group">
            <label class="form-label">Judul Buku:</label>
            <input type="text" id="judul" class="form-input-wide" required>
        </div>
        <div class="form-group">
            <label class="form-label">Penulis:</label>
            <input type="text" id="penulis" class="form-input-wide" required>
        </div>
        <div class="form-group">
            <label class="form-label">Tahun Terbit:</label>
            <input type="number" id="tahun_terbit" class="form-input" required>
        </div>

        <button type="submit" id="btn-submit" class="btn btn-submit">Simpan</button>
        <button type="button" id="btn-cancel" onclick="resetForm()" class="btn btn-cancel">Batal</button>
    </form>
</div>

<!-- Tabel Data Buku -->
<table class="table-buku">
    <thead>
        <tr>
            <th>Kategori</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Tahun Terbit</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="buku-table-body">
        <tr>
            <td colspan="5" align="center">Memuat data...</td>
        </tr>
    </tbody>
</table>

<!-- Panggil file JS eksternal dari public/js/buku.js -->
<script src="{{ asset('js/buku.js') }}"></script>
@endsection