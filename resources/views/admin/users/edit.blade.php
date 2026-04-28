@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Edit Data Anggota</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap"
                                   class="form-control"
                                   value="{{ $user->nama_lengkap }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label font-weight-bold">Username</label>
                            <input type="text" name="username" id="username"
                                   class="form-control"
                                   value="{{ $user->username }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label font-weight-bold">Password</label>
                            <small class="text-muted d-block mb-1">
                                (Kosongkan jika tidak ingin mengubah)
                            </small>
                            <input type="password" name="password" id="password"
                                   class="form-control" placeholder="******">
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label font-weight-bold">Alamat</label>
                            <textarea name="alamat" id="alamat"
                                      class="form-control" rows="3">{{ $user->alamat }}</textarea>
                        </div>

                        <!-- ❌ ROLE DIHAPUS TOTAL -->

                        <div class="d-flex justify-content-between border-top pt-3">
                            <a href="{{ route('adminusers.index') }}" class="btn btn-secondary shadow-sm">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary shadow-sm">
                                Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection