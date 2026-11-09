@extends('layouts.main')

@section('title', 'Manajemen Pengguna')

@section('content')

<div class="page-heading">
    <h1>Manajemen Pengguna 👥</h1>
    <p>Kelola data akun pengguna perpustakaan dan atur pembagian hak akses (role).</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <p>Total Pengguna</p>
        <h2>{{ $users->count() }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">👑</div>
        <p>Admin</p>
        <h2>{{ $users->filter(fn($u) => $u->hasRole('admin'))->count() }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">👔</div>
        <p>Petugas</p>
        <h2>{{ $users->filter(fn($u) => $u->hasRole('petugas'))->count() }}</h2>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🎓</div>
        <p>Siswa</p>
        <h2>{{ $users->filter(fn($u) => $u->hasRole('siswa') || $u->hasRole('anggota'))->count() }}</h2>
    </div>
</div>

<div class="content-card">

    <h3>Daftar Akun Pengguna</h3>
    <p>Daftar seluruh pengguna yang terdaftar pada sistem perpustakaan.</p>

    @if (session('success'))
        <div class="alert alert-success" style="background:#dcfce7;color:#15803d;padding:12px;border-radius:6px;margin-bottom:16px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:6px;margin-bottom:16px;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:6px;margin-bottom:16px;">
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
                    <th>NAMA</th>
                    <th>EMAIL</th>
                    <th>DATA ANGGOTA</th>
                    <th>ROLE SAAT INI</th>
                    <th>ATUR ROLE</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $item->name }}</strong>
                            @if ($item->id === auth()->id())
                                <span style="font-size:11px;background:#e0e7ff;color:#3730a3;padding:2px 6px;border-radius:4px;margin-left:4px;">Anda</span>
                            @endif
                        </td>
                        <td>{{ $item->email }}</td>
                        <td>
                            {{ $item->anggota->nama ?? '-' }}
                        </td>
                        <td>
                            @forelse ($item->roles as $r)
                                @if ($r->name === 'admin')
                                    <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;background:#fee2e2;color:#b91c1c;">
                                        Admin
                                    </span>
                                @elseif ($r->name === 'petugas')
                                    <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;background:#fef3c7;color:#b45309;">
                                        Petugas
                                    </span>
                                @else
                                    <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;background:#dbeafe;color:#1e40af;">
                                        {{ ucfirst($r->name) }}
                                    </span>
                                @endif
                            @empty
                                <span class="text-muted">Tanpa Role</span>
                            @endforelse
                        </td>
                        <td>
                            @can('kelola role pengguna')
                                <form action="{{ route('users.updateRole', $item->id) }}" method="POST" style="display:flex;gap:6px;align-items:center;">
                                    @csrf
                                    @method('PATCH')

                                    <select name="role" class="form-control" style="padding:6px 10px;font-size:13px;border-radius:6px;border:1px solid #cbd5e1;background:white;" required>
                                        @foreach ($roles as $roleOption)
                                            <option value="{{ $roleOption->name }}" {{ $item->hasRole($roleOption->name) ? 'selected' : '' }}>
                                                {{ ucfirst($roleOption->name) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="submit"
                                        style="background:#2563eb;color:white;border:none;padding:6px 12px;border-radius:6px;cursor:pointer;font-size:12px;white-space:nowrap;">
                                        Simpan
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endcan
                        </td>
                        <td>
                            @can('kelola data pengguna')
                                @if ($item->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $item->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="background:#dc2626;color:white;border:none;padding:6px 12px;border-radius:6px;cursor:pointer;font-size:12px;">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div style="font-size: 45px;">👥</div>
                            <h5 class="mt-3">Belum Ada Pengguna</h5>
                            <p class="text-muted">Belum ada data pengguna yang terdaftar.</p>
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

