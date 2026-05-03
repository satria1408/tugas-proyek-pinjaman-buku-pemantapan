@extends('layout.app')

@section('content')
<style>
    body {
        background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f') no-repeat center center fixed;
        background-size: cover;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: -1;
    }

    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: 0.2s;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }

    .book-img {
        height: 180px;
        object-fit: cover;
    }

    .badge-popular {
        position: absolute;
        top: 8px;
        left: 8px;
        background: red;
        color: #fff;
        font-size: 10px;
        padding: 3px 6px;
        border-radius: 6px;
    }

    .badge-ai {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #ffc107;
        color: #000;
        font-size: 10px;
        padding: 3px 6px;
        border-radius: 6px;
        font-weight: bold;
    }

    .card-body {
        padding: 10px;
    }

    h6 {
        font-size: 14px;
        margin-bottom: 4px;
    }

    small {
        font-size: 11px;
    }

    .btn-sm {
        font-size: 12px;
        padding: 5px;
    }

    .container {
        position: relative;
        z-index: 1;
    }

    h3, h5 {
        color: white;
    }

    .form-control, .btn {
        font-size: 13px;
    }
</style>

<div class="container py-4">

    <h3 class="mb-3 fw-bold">Dashboard Siswa</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- FILTER -->
    <form method="GET" action="{{ route('siswa.dashboard') }}" class="row mb-3">
        <div class="col-md-3">
            <select name="kategori" class="form-control form-control-sm">
                <option value="">Semua</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <input type="text" name="search" class="form-control form-control-sm"
                placeholder="Cari..."
                value="{{ request('search') }}">
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-light btn-sm w-50">Filter</button>
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-dark btn-sm w-50">Reset</a>
        </div>
    </form>
        
    <!-- Eai gemini -->
    @if(isset($aiBooks) && $aiBooks->count())
        <h5 class="mb-2">🔥 Rekomendasi AI</h5>

        <div class="row mb-4">
            @foreach($aiBooks as $book)
            <div class="col-md-2 col-6 mb-3">

                <div class="card position-relative border border-warning">

                    <div class="badge-ai">AI</div>

                    <a href="{{ route('siswa.books.show', $book->id) }}">
                        <img src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/300x400' }}"
                             class="card-img-top book-img">
                    </a>

                    <div class="card-body text-center">

                        <h6 class="fw-bold text-truncate">
                            {{ $book->judul }}
                        </h6>

                        <small class="text-muted d-block">
                            {{ $book->penulis }}
                        </small>

                        <span class="badge bg-warning text-dark mb-1">
                            {{ $book->kategori }}
                        </span>

                        <a href="{{ route('siswa.books.show', $book->id) }}" 
                           class="btn btn-warning btn-sm w-100">
                            Lihat
                        </a>

                    </div>

                </div>

            </div>
            @endforeach
        </div>
    @endif

    <!--  GRID BUKU -->
    <div class="row">
        @forelse($books as $book)
        <div class="col-md-2 col-6 mb-3">

            <div class="card position-relative">

                @if(($book->total_rating ?? 0) >= 3)
                    <div class="badge-popular">🔥</div>
                @endif

                <a href="{{ route('siswa.books.show', $book->id) }}">
                    <img src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/300x400' }}"
                         class="card-img-top book-img">
                </a>

                <div class="card-body text-center">

                    <h6 class="fw-bold text-truncate">
                        {{ $book->judul }}
                    </h6>

                    <small class="text-muted d-block">
                        {{ $book->penulis }}
                    </small>

                    <span class="badge bg-secondary mb-1">
                        {{ $book->kategori }}
                    </span>

                    <div style="font-size: 11px;">
                        @php $avg = round($book->average_rating ?? 0); @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= $avg ? '⭐' : '☆' }}
                        @endfor
                    </div>

                    <div class="mb-1">
                        <span class="badge {{ $book->stok > 0 ? 'bg-info text-dark' : 'bg-danger' }}">
                            {{ $book->stok }}
                        </span>
                    </div>

                    @if($book->stok > 0)
                        <a href="{{ route('siswa.transaksi', $book->id) }}" 
                           class="btn btn-primary btn-sm w-100">
                            Pinjam
                        </a>
                    @else
                        <button class="btn btn-secondary btn-sm w-100" disabled>
                            Habis
                        </button>
                    @endif

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