@extends('layout.app')

@section('content')
<style>
    body { background: #245db3; }

    .card { border: none; border-radius: 16px; }
    .card-header { border-radius: 16px 16px 0 0; font-weight: 600; }

    .table td { vertical-align: middle; }

    .cover-img {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ddd;
    }
</style>

<div class="container py-4">

    <h2 class="mb-4 fw-bold text-dark">Dashboard Siswa</h2>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif


    <!-- ========================= -->
    <!-- 🔵 TABEL 1: DAFTAR BUKU -->
    <!-- ========================= -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Daftar Buku
        </div>

        <div class="card-body">

            <!-- FILTER -->
            <form method="GET" action="{{ route('siswa.dashboard') }}" class="row mb-3">
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
                        placeholder="Cari judul buku..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button class="btn btn-primary w-50">Filter</button>
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary w-50">Reset</a>
                </div>
            </form>

            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="90">Cover</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Kategori</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <!-- COVER -->
                        <td>
                            @if($book->cover && file_exists(storage_path('app/public/' . $book->cover)))
                                <img src="{{ asset('storage/' . $book->cover) }}" class="cover-img">
                            @else
                                <span class="text-muted small">No Image</span>
                            @endif
                        </td>

                        <td class="fw-bold">{{ $book->judul }}</td>

                        <td>{{ $book->penulis }}</td>

                        <td>
                            <span class="badge bg-dark">{{ $book->penerbit }}</span>
                        </td>

                        <td>
                            <span class="badge bg-secondary">{{ $book->kategori }}</span>
                        </td>

                        <td class="text-center">
                            <span class="badge {{ $book->stok > 0 ? 'bg-info text-dark' : 'bg-secondary' }}">
                                {{ $book->stok }}
                            </span>
                        </td>

                        <td class="text-center">
                            @if($book->stok > 0)
                                <form action="{{ route('siswa.pinjam', $book->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-primary">Pinjam</button>
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


    <!-- ========================= -->
    <!-- 🟡 TABEL 2: DETAIL -->
    <!-- ========================= -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning text-dark">
            Detail Buku
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Deskripsi</th>
                        <th>Halaman</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td class="fw-bold">{{ $book->judul }}</td>
                        <td>{{ $book->penulis }}</td>
                        <td>{{ $book->penerbit }}</td>
                        <td>{{ $book->deskripsi ?? '-' }}</td>
                        <td>{{ $book->halaman ? $book->halaman . ' halaman' : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- ========================= -->
    <!-- 🟢 TABEL 3: DIPINJAM -->
    <!-- ========================= -->
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            Buku yang Dipinjam
        </div>

        <div class="card-body">

            @if($myBooks->isEmpty())
                <div class="text-center text-muted">Belum ada buku dipinjam</div>
            @else
                <table class="table table-hover text-center align-middle">
                    <thead>
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

                            <td class="fw-semibold">{{ $trans->book->judul }}</td>

                            <td>{{ $tglPinjam->format('d M Y') }}</td>

                            <td>{{ $tglKembali->format('d M Y') }}</td>

                            <td>
                                @if(now()->gt($tglKembali))
                                    <span class="badge bg-danger">Terlambat</span>
                                @else
                                    <span class="badge bg-success">Dipinjam</span>
                                @endif
                            </td>

                            <!-- DENDA -->
                            <td>
                                @if($trans->denda)
                                    <span class="badge bg-danger">
                                        Rp {{ number_format($trans->denda->jumlah_denda) }}
                                    </span>
                                @else
                                    <span class="badge bg-success">-</span>
                                @endif
                            </td>

                            <!-- AKSI -->
                            <td class="d-flex justify-content-center gap-2">

                                <form action="{{ route('siswa.kembali', $trans->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-warning text-white">
                                        Kembalikan
                                    </button>
                                </form>

                                <form action="{{ route('siswa.destroy', $trans->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus? Ini untuk salah pinjam!')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
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