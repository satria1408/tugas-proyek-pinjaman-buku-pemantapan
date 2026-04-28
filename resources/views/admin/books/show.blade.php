@extends('layout.app')

@section('content')
<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-8">

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

                    <!-- ⭐ RATING (FIX) -->
                    <p><b>Rating:</b>

                        @php
                            $avg = $book->average_rating ?? 0;
                        @endphp

                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($avg))
                                ⭐
                            @else
                                ☆
                            @endif
                        @endfor

                        ({{ $book->total_rating }} orang)
                    </p>

                    <!-- 🔥 FORM RATING -->
                    @auth
                    <form action="{{ route('rating.store', $book->id) }}" method="POST" class="mt-2">
                        @csrf

                        <div class="d-flex align-items-center gap-2">
                            <select name="rating" class="form-control w-auto">
                                <option value="5">⭐⭐⭐⭐⭐</option>
                                <option value="4">⭐⭐⭐⭐</option>
                                <option value="3">⭐⭐⭐</option>
                                <option value="2">⭐⭐</option>
                                <option value="1">⭐</option>
                            </select>

                            <button class="btn btn-primary btn-sm">
                                Kirim
                            </button>
                        </div>
                    </form>
                    @endauth

                    <hr>

                    <!-- CONTENT -->
                    <h5>Isi Buku</h5>

                    <div style="max-height:300px; overflow:auto; white-space:pre-line; text-align:justify;">
                        {{ $book->content }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection