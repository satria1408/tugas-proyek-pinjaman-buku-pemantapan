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
        align-items: center;
        justify-content: center;
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

    .form-control::placeholder {
        color: #ddd;
    }

    .form-control:focus {
        background: rgba(255,255,255,0.3);
        color: #fff;
        box-shadow: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        border: none;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f7971e, #ffd200);
        border: none;
        color: #000;
        font-weight: bold;
    }

    .btn-outline-secondary {
        border-color: #ddd;
        color: #fff;
    }

    .btn-outline-secondary:hover {
        background: #fff;
        color: #000;
    }

    .switch-link {
        cursor: pointer;
        font-size: 13px;
    }
</style>

<div class="login-wrapper">
    <div class="row justify-content-center w-100">
        <div class="col-md-4">
            <div class="card shadow-sm">

                <div class="card-header text-center py-3">
                    <h4 class="mb-0">Login Perpustakaan</h4>
                </div>

                <div class="card-body p-4">

                    {{-- ERROR --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div id="loginSiswa">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <h5 class="text-center mb-3">Login Siswa</h5>

                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
                        </form>

                        <div class="text-center mt-3">
                            <small class="switch-link" onclick="showAdmin()">Khusus Admin</small>
                        </div>
                    </div>

                    <div id="loginAdmin" style="display:none;">
                        <form action="{{ url('/admin/login') }}" method="POST">
                            @csrf

                            <h5 class="text-center mb-3 text-warning">Login Admin</h5>

                            <div class="mb-3">
                                <label class="form-label">Username Admin</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-warning w-100 py-2">Login Admin</button>
                        </form>

                        <div class="text-center mt-3">
                            <small class="switch-link" onclick="showSiswa()">⬅ Kembali ke Login Siswa</small>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="text-muted small">Belum punya akun?</p>
                        <a href="{{ url('/register') }}" class="btn btn-outline-secondary w-100">
                            Daftar Anggota
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT TOGGLE --}}
<script>
    function showAdmin() {
        document.getElementById('loginSiswa').style.display = 'none';
        document.getElementById('loginAdmin').style.display = 'block';
    }

    function showSiswa() {
        document.getElementById('loginAdmin').style.display = 'none';
        document.getElementById('loginSiswa').style.display = 'block';
    }
</script>

@endsection