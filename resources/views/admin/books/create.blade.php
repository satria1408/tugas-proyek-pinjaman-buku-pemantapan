@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Buku Baru</h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- COVER -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Cover Buku</label>
                            <input type="file"
                                   name="cover"
                                   class="form-control @error('cover') is-invalid @enderror">

                            @error('cover')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- JUDUL -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Buku</label>
                            <input type="text"
                                   name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   value="{{ old('judul') }}"
                                   placeholder="Masukkan judul buku"
                                   required>

                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Penulis</label>
                                <input type="text"
                                       name="penulis"
                                       class="form-control @error('penulis') is-invalid @enderror"
                                       value="{{ old('penulis') }}"
                                       placeholder="Nama penulis"
                                       required>

                                @error('penulis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Penerbit</label>
                                <input type="text"
                                       name="penerbit"
                                       class="form-control @error('penerbit') is-invalid @enderror"
                                       value="{{ old('penerbit') }}"
                                       placeholder="Nama penerbit"
                                       required>

                                @error('penerbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <input type="text"
                                       name="kategori"
                                       class="form-control"
                                       value="{{ old('kategori') }}"
                                       placeholder="Contoh: Novel, Teknologi">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Stok</label>
                                <input type="number"
                                       name="stok"
                                       class="form-control @error('stok') is-invalid @enderror"
                                       value="{{ old('stok') }}"
                                       min="0"
                                       required>

                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- HALAMAN -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah Halaman</label>
                            <input type="number"
                                   name="halaman"
                                   class="form-control @error('halaman') is-invalid @enderror"
                                   value="{{ old('halaman') }}"
                                   placeholder="Contoh: 120"
                                   min="1">

                            @error('halaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- DESKRIPSI -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Buku</label>
                            <textarea name="deskripsi"
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Masukkan deskripsi buku...">{{ old('deskripsi') }}</textarea>

                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Negara Asal</label>
        <input type="text"
               name="negara"
               class="form-control"
               value="{{ old('negara') }}"
               placeholder="Contoh: Indonesia, Jepang">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Tanggal Rilis</label>
        <input type="date"
               name="tanggal_rilis"
               class="form-control"
               value="{{ old('tanggal_rilis') }}">
    </div>
</div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Buku</label>

                            <textarea name="content"
                                      class="form-control @error('content') is-invalid @enderror"
                                      rows="8"
                                      placeholder="Masukkan isi buku di sini...">{{ old('content') }}</textarea>

                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- BUTTON -->
                        <div class="d-flex justify-content-between mt-4 border-top pt-3">
                            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary shadow-sm">
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-success shadow-sm">
                                Simpan Buku
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection