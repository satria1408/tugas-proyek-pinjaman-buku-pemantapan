@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Peminjaman (Admin)</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nama Siswa</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nama_lengkap }} ({{ $user->username }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Judul Buku</label>
                            <select name="book_id" class="form-select" required>
                                <option value="">-- Pilih Buku --</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->judul }} (Stok: {{ $book->stok }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Status Awal</label>
                            <select name="status" class="form-select">
                                <option value="pinjam">Sedang Dipinjam</option>
                                <option value="kembali">Langsung Dikembalikan</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success px-4">Simpan Transaksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection