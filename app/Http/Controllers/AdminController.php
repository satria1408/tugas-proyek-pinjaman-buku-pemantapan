<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function index()
    {
        $totalBuku = Book::count();
        $totalSiswa = User::where('role', 'siswa')->count();

        return view('admin.dashboard', compact('totalBuku', 'totalSiswa'));
    }

    public function transaksi()
    {
        $transactions = Transaction::with(['user', 'book', 'denda'])
            ->latest()
            ->get();

        return view('admin.dashboard', compact('transactions'));
    }
}