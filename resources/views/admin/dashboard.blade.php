@extends('layout.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dashboard Admin</h1>
    <span class="badge bg-primary px-3 py-2">Administrator Mode</span>
</div>

<div class="row">
    {{-- Card Kelola Data Buku --}}
    <div class="col-md-4">
        <div class="card text-white bg-success mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between">
                <span>Kelola Data Buku</span>
                <span class="badge bg-white text-success">{{ $totalBuku ?? 0 }}</span>
            </div>
            <div class="card-body">
                <p class="card-text">Tambah, Edit, dan Hapus data koleksi buku perpustakaan.</p>
                <a href="{{ route('books.index') }}" class="btn btn-light btn-sm w-100">Buka Menu</a>
            </div>
        </div>
    </div>

    {{-- Card Kelola Anggota --}}
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between text-dark">
                <span class="fw-bold">Kelola Anggota</span>
                <span class="badge bg-dark text-white">{{ $totalSiswa ?? 0 }}</span>
            </div>
            <div class="card-body text-dark">
                <p class="card-text">Manajemen data siswa dan aktivasi akun anggota.</p>
                <a href="{{ route('users.index') }}" class="btn btn-dark btn-sm w-100">Buka Menu</a>
            </div>
        </div>
    </div>

    {{-- Card Laporan Transaksi --}}
    <div class="col-md-4">
        <div class="card text-white bg-info mb-4 shadow-sm">
            <div class="card-header">Laporan Transaksi</div>
            <div class="card-body">
                <p class="card-text">Lihat dan cetak riwayat peminjaman serta pengembalian.</p>
                <a href="{{ route('transactions.index') }}" class="btn btn-light btn-sm w-100">Buka Menu</a>
            </div>
        </div>
    </div>
</div>
@endsection