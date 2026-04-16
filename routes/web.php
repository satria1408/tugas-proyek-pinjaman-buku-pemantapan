<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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

    // LOGIN SISWA
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');

    //  LOGIN ADMIN (dari tombol toggle)
    Route::post('/admin/login', 'loginAdmin')->name('admin.login');

    // REGISTER
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');

    // LOGOUT
    Route::post('/logout', 'logout')->name('logout');
});

// ===============================
// 3. ADMIN
// ===============================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        Route::resource('books', BookController::class);
        Route::resource('users', UserController::class);
        Route::resource('transactions', TransactionController::class);
    });

// ===============================
// 4. SISWA
// ===============================
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        Route::get('/dashboard', [SiswaController::class, 'index'])->name('dashboard');

        Route::get('/books', [SiswaController::class, 'index'])->name('books.index');
        Route::get('/transactions', [SiswaController::class, 'index'])->name('transactions.index');

        Route::post('/pinjam/{book_id}', [SiswaController::class, 'pinjamBuku'])->name('pinjam');
        Route::post('/kembali/{transaction_id}', [SiswaController::class, 'kembalikanBuku'])->name('kembali');

        Route::delete('/transaksi/{id}', [SiswaController::class, 'destroy'])->name('destroy');
    });
