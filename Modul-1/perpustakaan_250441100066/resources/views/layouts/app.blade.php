<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan Digital')</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <header class="header">
        <h1>Perpustakaan Digital</h1>
        <nav class="navbar">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('buku.index') }}">Daftar Buku</a>
        </nav>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Perpustakaan_250441100066. All rights reserved.</p>
    </footer>
</body>
</html>