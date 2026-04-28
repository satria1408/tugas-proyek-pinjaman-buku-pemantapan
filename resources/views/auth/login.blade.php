@extends('layout.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css')}}">
@endpush

@section('content')


<div class="login-wrapper">

    <div class="card shadow">

        <div class="card-body">

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM LOGIN --}}
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <input type="text" name="username" class="form-control"
                        placeholder="Username" required autofocus>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="form-control"
                        placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    Login
                </button>
            </form>

            {{-- SOCIAL LOGIN --}}
            <div class="text-center mt-4">
                <small>atau login dengan</small>

                <div class="d-flex justify-content-center gap-3 mt-2">

                    <!-- GOOGLE -->
                    <a href="{{ route('google.login') }}" class="social-btn">
                        <img src="https://cdn-icons-png.flaticon.com/512/281/281764.png" width="20">
                    </a>

                    <!-- FACEBOOK -->
                    <a href="#" class="social-btn">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" width="20">
                    </a>

                </div>
            </div>

            <hr class="my-4">

            {{-- REGISTER --}}
            <div class="text-center">
                <small>Belum punya akun?</small>
                <a href="{{ url('/register') }}" class="btn btn-outline-secondary w-100 mt-2">
                    Daftar Anggota
                </a>
            </div>

        </div>
    </div>

</div>

@endsection