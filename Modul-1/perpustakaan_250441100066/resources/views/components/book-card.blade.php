@props(['judul', 'penulis', 'tahun', 'url'])

<div class="card">
    <h3>{{ $judul }}</h3>
    <p>Penulis: {{ $penulis }}</p>
    <p>Tahun Terbit: {{ $tahun }}</p>

    @if (isset($slot) && !$slot->isEmpty())
        <div class="card-extra">
            {{ $slot }}
        </div>
    @endif

    <a href="{{ $url }}" class="btn">Lihat Detail</a>
</div>