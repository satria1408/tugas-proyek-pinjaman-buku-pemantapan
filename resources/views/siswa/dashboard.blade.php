@extends('layout.app')

@section('content')
<style>
    body { background: #245db3; }

    .card {
        border: none;
        border-radius: 14px;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .book-img {
        height: 260px;
        object-fit: cover;
    }

    .badge-popular {
        position: absolute;
        top: 10px;
        left: 10px;
        background: red;
        color: #fff;
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 8px;
    }
</style>

<div class="container py-4">

    <h2 class="mb-4 fw-bold text-dark">Dashboard Siswa</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- FILTER -->
    <form method="GET" action="{{ route('siswa.dashboard') }}" class="row mb-4">
        <div class="col-md-4">
            <select name="kategori" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <input type="text" name="search" class="form-control"
                placeholder="Cari buku..."
                value="{{ request('search') }}">
        </div>

        <div class="col-md-4 d-flex gap-2">
            <button class="btn btn-light w-50">Filter</button>
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-dark w-50">Reset</a>
        </div>
    </form>

    <!-- 📚 GRID BUKU -->
    <div class="row">
        @forelse($books as $book)
        <div class="col-md-3 mb-4">

            <div class="card position-relative">

                @if(($book->total_rating ?? 0) >= 3)
                    <div class="badge-popular">🔥 Populer</div>
                @endif

                <a href="{{ route('siswa.books.show', $book->id) }}">
                    <img src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/300x400' }}"
                         class="card-img-top book-img">
                </a>

                <div class="card-body text-center">

                    <h6 class="fw-bold">{{ $book->judul }}</h6>

                    <small class="text-muted d-block mb-1">
                        {{ $book->penulis }}
                    </small>

                    <span class="badge bg-secondary mb-2">
                        {{ $book->kategori }}
                    </span>

                    <!-- ⭐ RATING -->
                    <div class="mb-2">
                        @php $avg = round($book->average_rating ?? 0); @endphp

                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= $avg ? '⭐' : '☆' }}
                        @endfor

                        <br>
                        <small class="text-muted">
                            ({{ $book->total_rating ?? 0 }})
                        </small>
                    </div>

                    <!-- STOK -->
                    <span class="badge {{ $book->stok > 0 ? 'bg-info text-dark' : 'bg-danger' }}">
                        Stok: {{ $book->stok }}
                    </span>

                    <!-- AKSI -->
                    <div class="mt-2">
                        @if($book->stok > 0)
                            <a href="{{ route('siswa.transaksi', $book->id) }}" 
                               class="btn btn-primary btn-sm w-100">
                                📖 Pinjam
                            </a>
                        @else
                            <button class="btn btn-secondary btn-sm w-100" disabled>
                                Habis
                            </button>
                        @endif
                    </div>

                </div>

            </div>

        </div>
        @empty
        <div class="col-12 text-center text-white py-5">
            Tidak ada buku
        </div>
        @endforelse
    </div>

</div>
@endsection