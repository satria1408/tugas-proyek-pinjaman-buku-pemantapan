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
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trans)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $trans->user->nama_lengkap }}</td>
                        <td>{{ $trans->book->judul }}</td>
                        <td>{{ \Carbon\Carbon::parse($trans->tanggal_pinjam)->format('d M Y') }}</td>
                        <td>
                            <span class="badge {{ $trans->status == 'pinjam' ? 'bg-warning text-dark' : 'bg-success' }}">
                                {{ ucfirst($trans->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('transactions.edit', $trans->id) }}" class="btn btn-sm btn-info text-white">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('transactions.destroy', $trans->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection