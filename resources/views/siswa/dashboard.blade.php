@extends('layout.app')

@section('content')
<style>
    body {
        background: #245db3;
    }

    .card {
        border: none;
        border-radius: 16px;
    }

    .card-header {
        border-radius: 16px 16px 0 0;
        font-weight: 600;
        font-size: 18px;
    }

    .table th {
        font-weight: 600;
        font-size: 14px;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4e73df, #224abe);
        border: none;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f6c23e, #dda20a);
        border: none;
    }

    .badge {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 10px;
    }

    .table-hover tbody tr:hover {
        background-color: #4b72d4;
        transition: 0.2s;
    }
</style>

<div class="container py-4">

    <h2 class="mb-4 fw-bold text-dark"> Dashboard Siswa</h2>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">
            {{ session('error') }}
        </div>
    @endif


    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
             Peminjaman Buku
        </div>

        <div class="card-body">

            <form method="GET" class="row mb-3">
                <div class="col-md-4">
                    <select name="kategori" class="form-control">
                        <option value=""> Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" 
                                {{ request('kategori') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                        placeholder="🔍 Cari judul buku..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button class="btn btn-primary w-50">Filter</button>
                    <a href="" class="btn btn-secondary w-50">Reset</a>
                </div>
            </form>

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td class="fw-semibold">{{ $book->judul }}</td>

                        <td>
                            <span class="badge bg-secondary">
                                {{ $book->kategori }}
                            </span>
                        </td>

                        <td class="text-center">
                            <span class="badge {{ $book->stok > 0 ? 'bg-info text-dark' : 'bg-secondary' }}">
                                {{ $book->stok }}
                            </span>
                        </td>

                        <td class="text-center">
                            @if($book->stok > 0)
                                <form action="/siswa/pinjam/{{ $book->id }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-primary px-3">
                                        Pinjam
                                    </button>
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

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
             Buku yang Dipinjam
        </div>

        <div class="card-body">

            @if($myBooks->isEmpty())
                <div class="text-center text-muted py-4">
                     Belum ada buku dipinjam
                </div>
            @else
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Pinjam</th>
                            <th>Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($myBooks as $trans)
                        @php
                            $tglPinjam = \Carbon\Carbon::parse($trans->tanggal_pinjam);
                            $tglKembali = $tglPinjam->copy()->addDays($trans->lama_pinjam ?? 7);
                        @endphp

                        <tr class="{{ now()->gt($tglKembali) ? 'table-danger' : '' }}">

                            <td class="fw-semibold">
                                {{ $trans->book->judul }}
                            </td>

                            <td>
                                {{ $tglPinjam->format('d M Y') }}
                            </td>

                            <td>
                                {{ $tglKembali->format('d M Y') }}
                            </td>

                            <td>
                                @if(now()->gt($tglKembali))
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-success">Dipinjam</span>
                                @endif
                            </td>

                            <td>
                                @if($trans->denda)
                                    <span class="badge bg-danger">
                                        Rp {{ number_format($trans->denda->jumlah_denda) }}
                                    </span>
                                @else
                                    <span class="badge bg-success">-</span>
                                @endif
                            </td>

                            <!--  AKSI: KEMBALIKAN + DELETE -->
                            <td class="d-flex justify-content-center gap-2">

                                <!-- KEMBALIKAN -->
                                <form action="{{ route('siswa.kembali', $trans->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-warning px-3 text-white">
                                        Kembalikan
                                    </button>
                                </form>

                                <!-- DELETE -->
                                <form action="{{ route('siswa.destroy', $trans->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus? Ini untuk salah pinjam!')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger px-3">
                                        Delete
                                    </button>
                                </form>

                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>

</div>
@endsection