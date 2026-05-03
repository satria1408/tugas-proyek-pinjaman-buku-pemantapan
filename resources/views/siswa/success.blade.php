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
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        top: 0;
        left: 0;
        z-index: -1;
    }

    .card {
        border-radius: 14px;
        background: rgba(255,255,255,0.95);
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg text-center p-4">

                <h3 class="mb-3"> Berhasil Meminjam!</h3>

                <p class="text-muted">
                    Terimakasih sudah meminjam di perpustakaan.<br>
                    Semoga buku yang dipinjam dapat menambah wawasan kalian.
                </p>

                <a href="{{ route('siswa.dashboard') }}" 
                   class="btn btn-primary mt-3">
                    Kembali ke Dashboard
                </a>

            </div>

        </div>
    </div>
</div>
@endsection