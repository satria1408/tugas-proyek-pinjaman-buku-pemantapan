@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Edit Data Buku</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- COVER -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Cover Buku</label>

                            <div class="mb-2 text-center">
                                @if($book->cover && file_exists(storage_path('app/public/' . $book->cover)))
                                    <img src="{{ asset('storage/' . $book->cover) }}"
                                         width="120" height="160"
                                         style="object-fit: cover; border-radius: 8px; border:1px solid #ddd;">
                                @else
                                    <div class="text-muted">Belum ada cover</div>
                                @endif
                            </div>

                            <input type="file"
                                   name="cover"
                                   class="form-control @error('cover') is-invalid @enderror">

                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>

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
                                   value="{{ old('judul', $book->judul) }}"
                                   required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Penulis</label>
                                <input type="text"
                                       name="penulis"
                                       class="form-control"
                                       value="{{ old('penulis', $book->penulis) }}"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Penerbit</label>
                                <input type="text"
                                       name="penerbit"
                                       class="form-control"
                                       value="{{ old('penerbit', $book->penerbit) }}"
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <input type="text"
                                       name="kategori"
                                       class="form-control"
                                       value="{{ old('kategori', $book->kategori) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Stok</label>
                                <input type="number"
                                       name="stok"
                                       class="form-control"
                                       value="{{ old('stok', $book->stok) }}"
                                       min="0"
                                       required>
                            </div>
                        </div>

                        <!-- HALAMAN -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah Halaman</label>
                            <input type="number"
                                   name="halaman"
                                   class="form-control"
                                   value="{{ old('halaman', $book->halaman) }}"
                                   min="1">
                        </div>

                        <!-- DESKRIPSI -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Buku</label>
                            <textarea name="deskripsi"
                                      class="form-control"
                                      rows="3">{{ old('deskripsi', $book->deskripsi) }}</textarea>
                        </div>
                        <div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Negara Asal</label>
        <input type="text"
               name="negara"
               class="form-control"
               value="{{ old('negara', $book->negara) }}">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Tanggal Rilis</label>
        <input type="date"
               name="tanggal_rilis"
               class="form-control"
               value="{{ old('tanggal_rilis', $book->tanggal_rilis) }}">
    </div>
</div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Buku</label>
                            <textarea name="content"
                                      class="form-control"
                                      rows="6"
                                      placeholder="Masukkan isi buku...">{{ old('content', $book->content) }}</textarea>
                        </div>

                        <!-- BUTTON -->
                        <div class="d-flex justify-content-between mt-4 border-top pt-3">
                            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Update Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection