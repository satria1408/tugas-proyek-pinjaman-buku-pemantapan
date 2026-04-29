@extends('layout.app')

@section('content')
<style>
    body { background: #245db3; }
</style>

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h5>Konfirmasi Peminjaman</h5>
                </div>

                <div class="card-body">

                    <!-- INFO BUKU -->
                    <div class="text-center mb-3">
                        <h5 class="fw-bold">{{ $book->judul }}</h5>
                        <small class="text-muted">{{ $book->penulis }}</small>
                    </div>

                    <!-- ALERT -->
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- FORM -->
                    <form action="{{ route('siswa.transaksi.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="book_id" value="{{ $book->id }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Pinjam</label>
                            <input type="date"
                                   name="tanggal_pinjam"
                                   class="form-control"
                                   value="{{ date('Y-m-d') }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Kembali</label>
                            <input type="date"
                                   name="tanggal_kembali"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                                Batal
                            </a>

                            <button type="submit" class="btn btn-success">
                                Pinjam Sekarang
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection