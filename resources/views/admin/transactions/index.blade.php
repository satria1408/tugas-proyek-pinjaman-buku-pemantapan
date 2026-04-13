@extends('layout.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Kelola Transaksi</h2>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus"></i> Tambah Peminjaman Manual
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover mb-0 align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th> {{-- ✅ BARU --}}
                        <th>Status</th>
                        <th>Denda</th> {{-- ✅ BARU --}}
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transactions as $trans)

                    @php
                        $tglPinjam = \Carbon\Carbon::parse($trans->tanggal_pinjam);
                        $tglKembali = $tglPinjam->copy()->addDays($trans->lama_pinjam ?? 7);
                    @endphp

                    <tr class="{{ now()->gt($tglKembali) && $trans->status == 'pinjam' ? 'table-danger' : '' }}">

                        <td>{{ $loop->iteration }}</td>

                        <td class="text-start">
                            {{ $trans->user->nama_lengkap }}
                        </td>

                        <td class="text-start">
                            {{ $trans->book->judul }}
                        </td>

                        <td>
                            {{ $tglPinjam->format('d M Y') }}
                        </td>

                        {{-- ✅ TANGGAL KEMBALI --}}
                        <td>
                            {{ $tglKembali->format('d M Y') }}
                        </td>

                        {{-- ✅ STATUS DINAMIS --}}
                        <td>
                            @if($trans->status == 'kembali')
                                <span class="badge bg-success">Selesai</span>
                            @elseif(now()->gt($tglKembali))
                                <span class="badge bg-danger">Terlambat</span>
                            @else
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @endif
                        </td>

                        {{-- ✅ DENDA --}}
                        <td>
                            @if($trans->denda)
                                <span class="badge bg-danger">
                                    Rp {{ number_format($trans->denda->jumlah_denda) }}
                                </span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('transactions.edit', $trans->id) }}" class="btn btn-sm btn-info text-white">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('transactions.destroy', $trans->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            Belum ada transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection