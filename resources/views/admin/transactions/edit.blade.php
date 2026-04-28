@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Edit Status Transaksi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Peminjam</label>
                            <input type="text" class="form-control bg-light" value="{{ $transaction->user->nama_lengkap }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Buku</label>
                            <input type="text" class="form-control bg-light" value="{{ $transaction->book->judul }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ $transaction->tanggal_pinjam }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="pinjam" {{ $transaction->status == 'pinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                                <option value="kembali" {{ $transaction->status == 'kembali' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                            </select>
                            <small class="text-danger mt-1 d-block">* Mengubah status ke 'Kembali' akan otomatis menambah stok buku.</small>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection