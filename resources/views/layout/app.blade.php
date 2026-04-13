<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* 🔥 NAVBAR GLASS */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        /* TEXT NAVBAR */
        .navbar-glass .navbar-brand,
        .navbar-glass .nav-link,
        .navbar-glass .navbar-text {
            color: #fff !important;
        }

        .navbar-glass .nav-link.active {
            font-weight: bold;
            border-bottom: 2px solid #fff;
        }

        .navbar-glass .nav-link:hover {
            color: #ddd !important;
        }

        /* BADGE ROLE */
        .navbar-glass .badge {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        /* OPTIONAL: biar tidak ketabrak navbar */
        body {
            min-height: 100vh;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-glass mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Perpustakaan</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        {{-- ADMIN --}}
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">
                                    Kelola Buku
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                    Kelola Anggota
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                                    Transaksi
                                </a>
                            </li>
                        @endif

                        {{-- SISWA --}}
                        @if(Auth::user()->role == 'siswa')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}" href="{{ route('siswa.dashboard') }}">
                                    Dashboard & Peminjaman
                                </a>
                            </li>
                        @endif

                    </ul>

                    <div class="d-flex align-items-center">
                        <span class="navbar-text me-3">
                            Halo, <strong>{{ Auth::user()->nama_lengkap }}</strong>
                            <span class="badge ms-1">{{ ucfirst(Auth::user()->role) }}</span>
                        </span>

                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">Logout</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ERROR --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>