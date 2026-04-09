@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card mt-5 shadow-sm">
            <div class="card-header text-center bg-white py-3">
                <h4 class="mb-0">Login Perpustakaan</h4>
            </div>
            <div class="card-body p-4">
                {{-- Menampilkan Error Validasi (jika ada) --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="text-muted small">Belum punya akun?</p>
                    <a href="{{ url('/register') }}" class="btn btn-outline-secondary w-100">Daftar Anggota</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection