<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;

// 1. Halaman Depan
Route::get('/', function () { 
    return redirect()->route('login'); 
});

// 2. Autentikasi (Perhatikan penamaan route-nya, gunakan huruf kecil semua)
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login'); // Pastikan 'login' huruf kecil
    Route::post('/login', 'login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
});

// 3. Group Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Navigasi dashboard admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Resource route (Otomatis membuat books.index, books.create, dll)
    Route::resource('books', BookController::class)->names([
        'index' => 'books.index'
    ]);
    Route::resource('users', UserController::class)->names([
        'index' => 'users.index'
    ]);
    Route::resource('transactions', TransactionController::class)->names([
        'index' => 'transactions.index'
    ]);
});

// 4. Group Siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('dashboard');
    
    // Route tambahan agar navbar tidak error
    Route::get('/books', [SiswaController::class, 'index'])->name('books.index');
    Route::get('/transactions', [SiswaController::class, 'index'])->name('transactions.index');
    
    // Action
    Route::post('/pinjam/{book_id}', [SiswaController::class, 'pinjamBuku'])->name('pinjam');
    Route::post('/kembali/{transaction_id}', [SiswaController::class, 'kembalikanBuku'])->name('kembali');
});