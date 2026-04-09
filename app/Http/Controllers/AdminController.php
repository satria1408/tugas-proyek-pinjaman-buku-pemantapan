<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan Dashboard Admin & Monitoring Statistik
     */
    public function index()
    {
        // Mengambil total data dari database
        $totalBuku = Book::count();
        $totalSiswa = User::where('role', 'siswa')->count();

        return view('admin.dashboard', compact('totalBuku', 'totalSiswa'));
    }
}