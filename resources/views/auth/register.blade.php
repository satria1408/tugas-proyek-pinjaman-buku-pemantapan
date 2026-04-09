@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mt-5 shadow-sm">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 text-center">Daftar Anggota Baru</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ url('/register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimal 6 karakter.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Daftar Sekarang</button>
                        <a href="{{ url('/login') }}" class="btn btn-link text-center">Sudah punya akun? Kembali ke Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection