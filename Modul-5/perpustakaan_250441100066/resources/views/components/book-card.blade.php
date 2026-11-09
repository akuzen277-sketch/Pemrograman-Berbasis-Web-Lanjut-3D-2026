<div class="card">
    <h3>{{ $judul }}</h3>
    <p><strong>Penulis:</strong> {{ $penulis }}</p>
    <p><strong>Tahun Terbit:</strong> {{ $tahunTerbit }}</p>
    @if(isset($kategori))
        <p><strong>Kategori:</strong> {{ $kategori }}</p>
    @endif
    <div>{{ $slot }}</div>
</div>