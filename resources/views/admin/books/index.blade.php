@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Data Buku</h2>
        <a href="{{ route('books.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus"></i> Tambah Buku
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif


    <form method="GET" action="{{ route('books.index') }}" class="mb-3">
        <div class="row">

            <div class="col-md-3">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari judul buku..."
                    value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <select name="kategori" class="form-control">
                    <option value="">-- Semua Kategori --</option>

                    @foreach($categories as $cat)
                        <option value="{{ $cat }}"
                            {{ request('kategori') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    Filter
                </button>
            </div>

            <div class="col-md-2">
                <a href="{{ route('books.index') }}" class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>

        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th width="100">Stok</th>
                        <th width="180" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $book->judul }}</td>
                        <td>{{ $book->penulis }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $book->stok }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <em>Belum ada data buku yang tersedia.</em>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection