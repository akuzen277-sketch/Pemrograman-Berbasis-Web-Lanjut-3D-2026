@extends('layouts.main')

@section('title', 'Status Peminjaman')

@section('content')

<div class="page-heading">
    <h1>Status Peminjaman 📋</h1>
    <p>Pantau pengajuan dan riwayat peminjaman buku.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">📚</div>
        <p>Total Peminjaman</p>
        <h2>{{ $peminjamans->count() }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <p>Menunggu</p>
        <h2>{{ $peminjamans->where('status', 'menunggu')->count() }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <p>Disetujui</p>
        <h2>{{ $peminjamans->where('status', 'disetujui')->count() }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">❌</div>
        <p>Ditolak</p>
        <h2>{{ $peminjamans->where('status', 'ditolak')->count() }}</h2>
    </div>
</div>

<div class="content-card">

    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
        <div>
            <h3>Daftar Pengajuan Peminjaman</h3>
            <p>Daftar buku yang diajukan untuk dipinjam.</p>
        </div>

        @can('mengajukan peminjaman buku')
            <a href="{{ route('peminjaman.create') }}" class="btn-primary" style="white-space:nowrap;">
                + Ajukan Peminjaman Baru
            </a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="background:#dcfce7;color:#15803d;padding:12px;border-radius:6px;margin:16px 0;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:6px;margin:16px 0;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:6px;margin:16px 0;">
            <ul style="margin:0;padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-peminjaman align-middle">

            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAMA SISWA</th>
                    <th>JUDUL BUKU</th>
                    <th>TANGGAL PINJAM</th>
                    <th>TANGGAL KEMBALI</th>
                    <th>STATUS</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $peminjaman->anggota->nama ?? '-' }}
                        </td>

                        <td>
                            <strong>
                                {{ $peminjaman->buku->judul ?? '-' }}
                            </strong>
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                        </td>

                        <td>
                            @if ($peminjaman->status == 'menunggu' &&
                                auth()->user()->hasAnyRole(['admin', 'petugas']) &&
                                auth()->user()->can('memproses persetujuan peminjaman'))

                                <input type="date"
                                    form="setujui-{{ $peminjaman->id }}"
                                    name="tanggal_kembali"
                                    min="{{ date('Y-m-d') }}"
                                    class="form-control"
                                    required>

                            @elseif ($peminjaman->tanggal_kembali)

                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}

                            @elseif ($peminjaman->status == 'ditolak')

                                <span class="text-muted">-</span>

                            @else
                                <span class="text-muted">Belum ditentukan</span>
                            @endif
                        </td>

                        <td>
                            @if ($peminjaman->status === 'menunggu')

                                @if (auth()->user()->hasAnyRole(['admin', 'petugas']) && auth()->user()->can('memproses persetujuan peminjaman'))

                                    <div style="min-width: 200px;">

                                        <div class="mb-2">
                                            <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;background:#fef3c7;color:#b45309;">
                                                ⏳ Menunggu
                                            </span>
                                        </div>

                                        {{-- Form menyetujui --}}
                                        <form id="setujui-{{ $peminjaman->id }}"
                                            action="{{ route('peminjaman.update', $peminjaman->id) }}"
                                            method="POST" style="display:inline-block; margin-right:4px; margin-bottom:4px;">

                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="status" value="disetujui">

                                            <button type="submit"
                                                style="background:#16a34a;color:white;border:none;
                                                padding:7px 12px;border-radius:6px;cursor:pointer;font-weight:500;">
                                                ✓ Setujui
                                            </button>
                                        </form>

                                        {{-- Form menolak --}}
                                        <form action="{{ route('peminjaman.update', $peminjaman->id) }}"
                                            method="POST" style="display:inline-block;">

                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="status" value="ditolak">

                                            <button type="submit"
                                                style="background:#dc2626;color:white;border:none;
                                                padding:7px 12px;border-radius:6px;cursor:pointer;font-weight:500;">
                                                ✕ Tolak
                                            </button>
                                        </form>

                                    </div>

                                @else
                                    <span style="display:inline-block;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600;background:#fef3c7;color:#b45309;">
                                        ⏳ Menunggu Persetujuan
                                    </span>
                                @endif

                            @elseif ($peminjaman->status === 'disetujui')

                                <div>
                                    <span style="display:inline-block;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600;background:#dcfce7;color:#15803d;">
                                        ✓ Disetujui
                                    </span>

                                    @if (auth()->user()->hasAnyRole(['admin', 'petugas']) && auth()->user()->can('mencatat pengembalian buku'))
                                        <div class="mt-2">
                                            <form action="{{ route('peminjaman.return', $peminjaman->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    style="background:#2563eb;color:white;border:none;
                                                    padding:5px 10px;border-radius:6px;cursor:pointer;font-size:12px;">
                                                    Kembalikan Buku
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                            @elseif ($peminjaman->status === 'ditolak')

                                <span style="display:inline-block;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600;background:#fee2e2;color:#b91c1c;">
                                    ✕ Ditolak
                                </span>

                            @elseif ($peminjaman->status === 'dikembalikan')

                                <span style="display:inline-block;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600;background:#e0f2fe;color:#0369a1;">
                                    ✔ Dikembalikan
                                </span>

                            @else

                                <span class="text-muted">{{ ucfirst($peminjaman->status) }}</span>

                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div style="font-size: 45px;">📚</div>
                            <h5 class="mt-3">Belum Ada Pengajuan</h5>
                            <p class="text-muted">
                                Belum ada riwayat pengajuan peminjaman buku.
                            </p>
                        </td>
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
