@extends('layout.app')

@section('content')
<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Data Buku</h2>

        <a href="{{ route('admin.books.create') }}" class="btn btn-primary shadow-sm">
            + Tambah Buku
        </a>
    </div>

    @if(session('success'))  
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- FILTER -->
    <form method="GET" action="{{ route('admin.books.index') }}" class="mb-4">
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
                <button class="btn btn-primary w-100">Filter</button>
            </div>

            <div class="col-md-2">
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary w-100">
                    Reset
                </a>
            </div>

        </div>
    </form>

    <!-- GRID -->
    <div class="row">

        @forelse($books as $book)
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm border-0 h-100">

                <!-- COVER -->
                <a href="{{ route('admin.books.show', $book->id) }}">
                    <img src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/300x400' }}"
                         class="card-img-top"
                         style="height:300px; object-fit:cover;">
                </a>

                <div class="card-body text-center">

                    <!-- JUDUL -->
                    <h6 class="fw-bold mb-1">{{ $book->judul }}</h6>

                    <!-- NEGARA + TAHUN -->
                    <small class="text-muted d-block mb-1">
                        {{ $book->negara ?? '-' }} 
                        • 
                        {{ $book->tanggal_rilis ? \Carbon\Carbon::parse($book->tanggal_rilis)->format('Y') : '-' }}
                    </small>

                    <!-- RATING -->
                    @php
                        $avg = $book->ratings->avg('rating');
                        $total = $book->ratings->count();
                    @endphp

                    <div class="mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($avg))
                                ⭐
                            @else
                                ☆
                            @endif
                        @endfor

                        <small class="text-muted">({{ $total }})</small>
                    </div>

                    <!-- AKSI -->
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('admin.books.edit', $book->id) }}" 
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin hapus buku ini?')">
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">
            Belum ada data buku
        </div>
        @endforelse

    </div>

</div>

<style>
.card:hover {
    transform: scale(1.03);
    transition: 0.3s;
}
</style>

@endsection