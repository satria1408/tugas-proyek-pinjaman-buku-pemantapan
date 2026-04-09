<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar buku dan buku yang sedang dipinjam user.
     */
    public function index(): View
    {
        // Fitur List Buku
        $books = Book::all();

        // List buku yang sedang dipinjam user (Eager Loading 'book' agar efisien)
        $myBooks = Transaction::with('book')
            ->where('user_id', Auth::id())
            ->where('status', 'pinjam')
            ->get();

        return view('siswa.dashboard', compact('books', 'myBooks'));
    }

    /**
     * Logika untuk meminjam buku.
     */
    public function pinjamBuku($book_id): RedirectResponse
    {
        $book = Book::findOrFail($book_id);

        // Validasi: Cek apakah user sudah meminjam buku yang sama dan belum dikembalikan
        $alreadyBorrowed = Transaction::where('user_id', Auth::id())
            ->where('book_id', $book_id)
            ->where('status', 'pinjam')
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', 'Anda masih meminjam buku ini!');
        }

        // Cek stok buku
        if ($book->stok > 0) {
            Transaction::create([
                'user_id' => Auth::id(),
                'book_id' => $book_id,
                'tanggal_pinjam' => Carbon::now(),
                'status' => 'pinjam'
            ]);

            $book->decrement('stok');

            return back()->with('success', 'Buku berhasil dipinjam');
        }

        return back()->with('error', 'Stok buku habis!');
    }

    /**
     * Logika untuk mengembalikan buku.
     */
    public function kembalikanBuku($transaction_id): RedirectResponse
    {
        // Validasi transaksi milik user dan statusnya memang sedang dipinjam
        $transaksi = Transaction::where('id', $transaction_id)
            ->where('user_id', Auth::id())
            ->where('status', 'pinjam')
            ->firstOrFail();

        $transaksi->update([
            'tanggal_kembali' => Carbon::now(),
            'status' => 'kembali'
        ]);

        // Kembalikan stok buku melalui relasi
        $transaksi->book->increment('stok');

        return back()->with('success', 'Buku berhasil dikembalikan');
    }
}