@extends('layouts.main')

@section('title', 'Laporan Perpustakaan')

@section('content')

<div class="page-heading">
    <h1>Laporan Perpustakaan 📊</h1>
    <p>Rekap data buku, kategori, dan aktivitas peminjaman di sistem perpustakaan.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📚</div>
        <p>Total Buku</p>
        <h2>{{ $totalBuku }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🏷️</div>
        <p>Total Kategori</p>
        <h2>{{ $totalKategori }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <p>Total Peminjaman</p>
        <h2>{{ $totalPeminjaman }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <p>Sedang Dipinjam</p>
        <h2>{{ $peminjamanDisetujui }}</h2>
    </div>
</div>

<div class="content-card mb-4">
    <h3>Ringkasan Status Peminjaman Buku</h3>
    <p>Distribusi status peminjaman yang diajukan oleh siswa.</p>

    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;margin-top:16px;">
        <div style="background:#fef3c7;padding:16px;border-radius:10px;border-left:5px solid #d97706;">
            <p style="margin:0;color:#92400e;font-size:13px;font-weight:600;">⏳ Menunggu Persetujuan</p>
            <h3 style="margin:8px 0 0;color:#78350f;font-size:24px;">{{ $peminjamanMenunggu }}</h3>
        </div>

        <div style="background:#dcfce7;padding:16px;border-radius:10px;border-left:5px solid #16a34a;">
            <p style="margin:0;color:#166534;font-size:13px;font-weight:600;">✓ Disetujui (Sedang Dipinjam)</p>
            <h3 style="margin:8px 0 0;color:#14532d;font-size:24px;">{{ $peminjamanDisetujui }}</h3>
        </div>

        <div style="background:#fee2e2;padding:16px;border-radius:10px;border-left:5px solid #dc2626;">
            <p style="margin:0;color:#991b1b;font-size:13px;font-weight:600;">✕ Ditolak</p>
            <h3 style="margin:8px 0 0;color:#7f1d1d;font-size:24px;">{{ $peminjamanDitolak }}</h3>
        </div>

        <div style="background:#e0f2fe;padding:16px;border-radius:10px;border-left:5px solid #0284c7;">
            <p style="margin:0;color:#075985;font-size:13px;font-weight:600;">✔ Dikembalikan</p>
            <h3 style="margin:8px 0 0;color:#0c4a6e;font-size:24px;">{{ $peminjamanDikembalikan }}</h3>
        </div>
    </div>
</div>

<div class="content-card mb-4">
    <h3>Rekap Buku per Kategori</h3>
    <p>Jumlah koleksi buku yang terdaftar berdasarkan kategorinya.</p>

    <div class="table-responsive">
        <table class="table table-peminjaman align-middle">
            <thead>
                <tr>
                    <th style="width:70px;">NO</th>
                    <th>NAMA KATEGORI</th>
                    <th style="width:200px;">JUMLAH BUKU</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bukuPerKategori as $kat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $kat->nama_kategori }}</strong></td>
                        <td>
                            <span style="display:inline-block;padding:4px 12px;border-radius:20px;font-size:13px;font-weight:600;background:#e0e7ff;color:#3730a3;">
                                {{ $kat->bukus_count }} Buku
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">Belum ada data kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="content-card mb-4">
    <h3>Buku Paling Sering Dipinjam</h3>
    <p>Top 10 buku dengan riwayat peminjaman terbanyak.</p>

    <div class="table-responsive">
        <table class="table table-peminjaman align-middle">
            <thead>
                <tr>
                    <th style="width:70px;">NO</th>
                    <th>JUDUL BUKU</th>
                    <th>PENULIS</th>
                    <th style="width:200px;">TOTAL DIPINJAM</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamanPerBuku as $buku)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $buku->judul }}</strong></td>
                        <td>{{ $buku->penulis }}</td>
                        <td>
                            <span style="display:inline-block;padding:4px 12px;border-radius:20px;font-size:13px;font-weight:600;background:#fef3c7;color:#b45309;">
                                {{ $buku->peminjamans_count }} Kali
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada riwayat peminjaman buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="content-card mb-4">
    <h3>Aktivitas Peminjaman Terbaru</h3>
    <p>Daftar 10 riwayat transaksi peminjaman buku terkini.</p>

    <div class="table-responsive">
        <table class="table table-peminjaman align-middle">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>PEMINJAM</th>
                    <th>BUKU</th>
                    <th>TGL PINJAM</th>
                    <th>TGL KEMBALI</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamanTerbaru as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->anggota->nama ?? '-' }}</td>
                        <td><strong>{{ $p->buku->judul ?? '-' }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                        <td>
                            @if ($p->tanggal_kembali)
                                {{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($p->status === 'disetujui')
                                <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;background:#dcfce7;color:#15803d;">
                                    ✓ Disetujui
                                </span>
                            @elseif ($p->status === 'ditolak')
                                <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;background:#fee2e2;color:#b91c1c;">
                                    ✕ Ditolak
                                </span>
                            @elseif ($p->status === 'dikembalikan')
                                <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;background:#e0f2fe;color:#0369a1;">
                                    ✔ Dikembalikan
                                </span>
                            @else
                                <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;background:#fef3c7;color:#b45309;">
                                    ⏳ Menunggu
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada transaksi peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <br>

    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
        Kembali ke Dashboard
    </a>
</div>

@endsection

