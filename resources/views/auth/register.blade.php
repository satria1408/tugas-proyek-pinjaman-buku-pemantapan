@extends('layout.app')

@section('content')

<style>
    body {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                    url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f');
        background-size: cover;
        background-position: center;
        height: 100vh;
        overflow: hidden;
    }

    .login-wrapper {
        height: calc(100vh - 70px);
        display: flex;
        justify-content: center;
        align-items: center;
        transform: translateY(-20px);
    }

    .card {
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
    }

    .card-header {
        background: transparent !important;
        border-bottom: none;
        color: #fff;
    }

    .form-control {
        background: rgba(255,255,255,0.2);
        border: none;
        color: #fff;
    }

    .form-control:focus {
        background: rgba(255,255,255,0.3);
        color: #fff;
        box-shadow: none;
    }

    .form-control::placeholder {
        color: #ddd;
    }

    .form-text {
        color: #ddd;
    }

    .btn-success {
        background: linear-gradient(135deg, #33ee97, #00f2fe);
        border: none;
    }

    .btn-link {
        color: #fff;
        text-decoration: none;
    }

    .btn-link:hover {
        text-decoration: underline;
    }
</style>

<div class="login-wrapper">
    <div class="col-md-5">
        <div class="card shadow-lg p-4">

            <div class="text-center mb-3">
                <h4 class="fw-bold">📝 Daftar Anggota</h4>
                <p class="small text-light">Buat akun baru untuk meminjam buku</p>
            </div>

            <form action="{{ url('/register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <input type="text" name="nama_lengkap" placeholder="Nama Lengkap"
                        class="form-control @error('nama_lengkap') is-invalid @enderror"
                        value="{{ old('nama_lengkap') }}" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="username" placeholder="Username"
                        class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username') }}" required>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" placeholder="Password"
                        class="form-control @error('password') is-invalid @enderror" required>
                    <small class="form-text">Minimal 6 karakter</small>
                </div>

                <div class="mb-3">
                    <textarea name="alamat" rows="2" placeholder="Alamat"
                        class="form-control">{{ old('alamat') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success w-100 mb-2">
                    Daftar Sekarang
                </button>

                <div class="text-center">
                    <a href="{{ url('/login') }}" class="btn-link">
                        Sudah punya akun? Login
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection