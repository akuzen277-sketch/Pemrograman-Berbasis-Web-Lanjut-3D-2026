<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <header>
        <h1>Sistem Informasi Perpustakaan</h1>
        <nav>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('buku.index') }}">Daftar Buku</a>
        </nav>
    </header>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <p>&copy; 2026 Perpustakaan Digital</p>
    </footer>
</body>
</html>