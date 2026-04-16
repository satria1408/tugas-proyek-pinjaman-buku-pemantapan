@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Anggota Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-control-label font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-control-label font-weight-bold">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-control-label font-weight-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-control-label font-weight-bold">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                        </div>

                        
                        <div class="mb-3">
                            <label for="role" class="form-control-label font-weight-bold">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="siswa">Siswa</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between border-top pt-3">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary shadow-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success shadow-sm">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection