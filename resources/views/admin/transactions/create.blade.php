@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Peminjaman (Admin)</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf

                        {{-- PILIH SISWA --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Siswa</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->nama_lengkap }} ({{ $user->username }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- PILIH BUKU --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Buku</label>
                            <select name="book_id" class="form-select" required>
                                <option value="">-- Pilih Buku --</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">
                                        {{ $book->judul }} (Stok: {{ $book->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- TANGGAL PINJAM --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Pinjam</label>
                            <input 
                                type="date" 
                                name="tanggal_pinjam" 
                                id="tanggal_pinjam"
                                class="form-control" 
                                value="{{ date('Y-m-d') }}" 
                                required
                            >
                        </div>

                        {{-- TANGGAL KEMBALI (DEADLINE) --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Kembali (Deadline)</label>
                            <input 
                                type="date" 
                                name="tanggal_kembali" 
                                id="tanggal_kembali"
                                class="form-control"
                                required
                            >
                            <small class="text-muted">Maksimal 14 hari dari tanggal pinjam</small>
                        </div>

                        {{-- STATUS --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Awal</label>
                            <select name="status" class="form-select">
                                <option value="pinjam">Sedang Dipinjam</option>
                                <option value="kembali">Langsung Dikembalikan</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success px-4">Simpan Transaksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT BATAS TANGGAL --}}
<script>
    const pinjamInput = document.getElementById('tanggal_pinjam');
    const kembaliInput = document.getElementById('tanggal_kembali');

    function setBatasTanggal() {
        let pinjam = new Date(pinjamInput.value);

        if (!pinjamInput.value) return;

        // min = besok dari tanggal pinjam
        let minDate = new Date(pinjam);
        minDate.setDate(minDate.getDate() + 1);

        // max = +14 hari
        let maxDate = new Date(pinjam);
        maxDate.setDate(maxDate.getDate() + 14);

        kembaliInput.min = minDate.toISOString().split('T')[0];
        kembaliInput.max = maxDate.toISOString().split('T')[0];
    }

    pinjamInput.addEventListener('change', setBatasTanggal);

    // auto set saat pertama load
    window.onload = setBatasTanggal;
</script>
@endsection