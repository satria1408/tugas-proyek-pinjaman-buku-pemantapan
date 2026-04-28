<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">

            <!-- 🔥 JUDUL TENGAH SIMPLE -->
            <a class="navbar-brand mx-auto" href="#">
                Perpustakaan Online
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                @auth
                    <ul class="navbar-nav me-auto">

                        {{-- ADMIN --}}
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('admin.books.index') }}">
                                    Buku
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                    Anggota
                                </a>
                            </li>
                        @endif

                        {{-- SISWA --}}
                        @if(Auth::user()->role == 'siswa')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}" href="{{ route('siswa.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                        @endif

                    </ul>

                    <div class="d-flex align-items-center">
                        <span class="navbar-text me-3">
                            {{ Auth::user()->nama_lengkap }}
                        </span>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm">Logout</button>
                        </form>
                    </div>
                @endauth

            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 80px;">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>