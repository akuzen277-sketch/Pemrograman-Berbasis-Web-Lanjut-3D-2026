
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Digital')</title>

    @vite(['resources/css/app.css'])

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buku.css') }}">
</head>

@php
    $user = auth()->user();

    $theme = 'theme-siswa';
    $roleName = 'Siswa';

    if ($user && $user->hasRole('admin')) {
        $theme = 'theme-admin';
        $roleName = 'Admin';
    } elseif ($user && $user->hasRole('petugas')) {
        $theme = 'theme-petugas';
        $roleName = 'Petugas';
    }
@endphp

<body>
<div class="dashboard-wrapper {{ $theme }}">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="sidebar-brand">
            <div class="sidebar-logo">📚</div>
            <div>
                <h3>Perpustakaan</h3>
                <span>Digital Library System</span>
            </div>
        </div>

        <p class="menu-label">MENU UTAMA</p>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home', 'dashboard') ? 'active' : '' }}">
                    <span>🏠</span>
                    <span>Dashboard</span>
                </a>
            </li>

            @can('view buku')
            <li>
                <a href="{{ route('buku.index') }}"
                   class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">
                    <span>📖</span>
                    <span>Data Buku</span>
                </a>
            </li>
            @endcan

            @canany(['kelola peminjaman', 'melihat status peminjaman sendiri', 'melihat riwayat peminjaman sendiri', 'mengajukan peminjaman buku'])
            <li>
                <a href="{{ route('peminjaman.index') }}"
                   class="{{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
                    <span>📋</span>
                    <span>Peminjaman</span>
                </a>
            </li>
            @endcanany

            @canany(['kelola data pengguna', 'kelola role pengguna'])
            <li>
                <a href="{{ route('users.index') }}"
                   class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <span>👥</span>
                    <span>Pengguna</span>
                </a>
            </li>
            @endcanany

            @can('lihat laporan perpustakaan')
            <li>
                <a href="{{ route('laporan.index') }}"
                   class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <span>📊</span>
                    <span>Laporan</span>
                </a>
            </li>
            @endcan
        </ul>

        <div class="sidebar-bottom">
            <div class="sidebar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <strong>{{ $user->name ?? 'Pengguna' }}</strong>
                    <span>{{ $roleName }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    ↪ Keluar
                </button>
            </form>
        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <main class="main-content">

        <header class="topbar">
            <div>
                <h2>Sistem Informasi Perpustakaan</h2>
                <p>Selamat datang di perpustakaan digital</p>
            </div>

            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-info">
                    <strong>{{ $user->name ?? 'Pengguna' }}</strong>
                    <span class="role-badge">{{ $roleName }}</span>
                </div>
            </div>
        </header>

        <section class="page-content">
            @yield('content')
        </section>

        <footer class="main-footer">
            &copy; 2026 Sistem Informasi Perpustakaan
        </footer>

    </main>

</div>
</body>
</html>
