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
        border-radius: 14px;
        backdrop-filter: blur(6px);
        background: rgba(255,255,255,0.95);
    }

    .container {
        position: relative;
        z-index: 1;
    }

    .book-cover {
        width: 100px;
        height: 140px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        margin-bottom: 10px;
    }

    h6 {
        margin-bottom: 4px;
    }

    .form-control {
        font-size: 14px;
    }

    .btn {
        font-size: 14px;
    }
</style>

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-lg">

                <div class="card-header bg-primary text-white text-center">
                    <h5>Konfirmasi Peminjaman</h5>
                </div>

                <div class="card-body text-center">

                    <!-- 📚 COVER -->
                    <img src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/150x200' }}"
                         class="book-cover">

                    <!-- INFO BUKU -->
                    <h6 class="fw-bold">{{ $book->judul }}</h6>
                    <small class="text-muted d-block mb-3">
                        {{ $book->penulis }}
                    </small>

                    <!-- ALERT -->
                    @if(session('error'))
                        <div class="alert alert-danger py-2 text-start">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- FORM -->
                    <form action="{{ route('siswa.transaksi.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="book_id" value="{{ $book->id }}">

                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">Tanggal Pinjam</label>
                            <input type="date"
                                   name="tanggal_pinjam"
                                   class="form-control form-control-sm"
                                   value="{{ date('Y-m-d') }}"
                                   required>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">Tanggal Kembali</label>
                            <input type="date"
                                   name="tanggal_kembali"
                                   class="form-control form-control-sm"
                                   required>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary btn-sm">
                                Batal
                            </a>

                            <button type="submit" class="btn btn-success btn-sm">
                                Pinjam
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>
@endsection