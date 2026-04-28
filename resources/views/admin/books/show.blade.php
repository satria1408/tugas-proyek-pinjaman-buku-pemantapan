@extends('layout.app')

@section('content')
<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-10">

            <div class="card shadow border-0 p-4">

                <!-- COVER -->
                <div class="text-center mb-4">
                    <img src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/300x400' }}"
                         class="img-fluid rounded"
                         style="max-height:400px;">
                </div>

                <!-- DATA -->
                <div class="text-start">

                    <h3 class="fw-bold mb-3">{{ $book->judul }}</h3>

                    <p><b>Penulis:</b> {{ $book->penulis }}</p>
                    <p><b>Penerbit:</b> {{ $book->penerbit }}</p>
                    <p><b>Kategori:</b> {{ $book->kategori }}</p>

                    <p><b>Deskripsi:</b><br>
                        {{ $book->deskripsi }}
                    </p>

                    <hr>

                    <!-- 📖 ISI BUKU SLIDE -->
                    <h5 class="mb-3">Isi Buku</h5>

                    <div class="ebook-container">

                        @foreach(str_split($book->content ?? '', 800) as $page)
                            <div class="ebook-page">
                                {{ $page }}
                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- 🔥 STYLE EBOOK -->
<style>
.ebook-container {
    display: flex;
    overflow-x: auto;
    gap: 20px;
    padding: 10px;
    scroll-snap-type: x mandatory;
}

.ebook-container::-webkit-scrollbar {
    height: 8px;
}

.ebook-container::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

.ebook-page {
    min-width: 320px;
    max-width: 320px;
    height: 420px;
    padding: 20px;
    border-radius: 12px;
    background: #f8f9fa;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);

    scroll-snap-align: start;

    text-align: justify;
    line-height: 1.7;
    font-size: 14px;
}
</style>

@endsection