<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

// ===============================
// 1. HALAMAN DEPAN
// ===============================
Route::get('/', function () {
    return redirect()->route('login');
});


// ===============================
// 2. AUTH
// ===============================
Route::controller(AuthController::class)->group(function () {

    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');

    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');

    Route::post('/logout', 'logout')->name('logout');

    Route::get('/auth/google', 'redirectToGoogle')->name('google.login');
    Route::get('/auth/google/callback', 'handleGoogleCallback');
});


// ===============================
// 3. DASHBOARD GLOBAL
// ===============================
Route::middleware(['auth'])->get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('siswa.dashboard');
});


// ===============================
// 4. ADMIN
// ===============================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::resource('books', BookController::class);
        Route::resource('users', UserController::class);
        Route::resource('transactions', TransactionController::class);
    });


// ===============================
// 5. SISWA
// ===============================
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

        // lihat detail buku
        Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');

        Route::post('/pinjam/{book_id}', [UserController::class, 'pinjamBuku'])->name('pinjam');
        Route::post('/kembali/{transaction_id}', [UserController::class, 'kembalikanBuku'])->name('kembali');

        Route::delete('/transaksi/{id}', [UserController::class, 'destroyTransaction'])->name('destroy');
    });


// ===============================
// 6. ⭐ RATING (WAJIB ADA)
// ===============================
Route::middleware(['auth'])->group(function () {

    Route::post('/rating/{book}', [RatingController::class, 'store'])
        ->name('rating.store');

});