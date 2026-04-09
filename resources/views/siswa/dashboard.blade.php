@extends('layout.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Dashboard Siswa</h1>

    <!-- Notifikasi/Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Kolom Daftar Buku -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Peminjaman Buku</h4>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-3">Daftar Buku Tersedia</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul</th>
                                    <th class="text-center">Stok</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                <tr>
                                    <td>{{ $book->judul }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $book->stok > 0 ? 'bg-info' : 'bg-secondary' }}">
                                            {{ $book->stok }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($book->stok > 0)
                                            <form action="/siswa/pinjam/{{ $book->id }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary">Pinjam</button>
                                            </form>
                                        @else
                                            <span class="badge bg-danger">Habis</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Pengembalian Buku -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Pengembalian Buku</h4>
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-3">Buku yang Sedang Dipinjam</h5>
                    
                    @if($myBooks->isEmpty())
                        <div class="alert alert-light border text-center py-4">
                            <p class="text-muted mb-0">Tidak ada buku yang sedang dipinjam.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Judul</th>
                                        <th>Tgl Pinjam</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myBooks as $trans)
                                    <tr>
                                        <td>{{ $trans->book->judul }}</td>
                                        <td>{{ \Carbon\Carbon::parse($trans->tanggal_pinjam)->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <form action="/siswa/kembali/{{ $trans->id }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning text-white">Kembalikan</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection