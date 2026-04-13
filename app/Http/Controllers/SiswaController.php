<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\Denda;
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
        $books = Book::all();

        $myBooks = Transaction::with('book', 'denda')
            ->where('user_id', Auth::id())
            ->where('status', 'pinjam')
            ->get();

        return view('siswa.dashboard', compact('books', 'myBooks'));
    }

    /**
     * Pinjam buku
     */
    public function pinjamBuku($book_id): RedirectResponse
    {
        $book = Book::findOrFail($book_id);

        // Cek sudah pinjam atau belum
        $alreadyBorrowed = Transaction::where('user_id', Auth::id())
            ->where('book_id', $book_id)
            ->where('status', 'pinjam')
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', 'Anda masih meminjam buku ini!');
        }

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
     * Kembalikan buku + HITUNG DENDA
     */
    public function kembalikanBuku($transaction_id): RedirectResponse
    {
        $transaction = Transaction::with('book', 'denda')
            ->where('id', $transaction_id)
            ->where('user_id', Auth::id())
            ->where('status', 'pinjam')
            ->firstOrFail();

        $tglPinjam = Carbon::parse($transaction->tanggal_pinjam);
        $batas = $tglPinjam->copy()->addDays(7); // batas 7 hari
        $today = Carbon::now();

        $hariTelat = 0;
        $jumlahDenda = 0;

        if ($today->gt($batas)) {
            $hariTelat = $batas->diffInDays($today);
            $jumlahDenda = $hariTelat * 1000;

            if (!$transaction->denda) {
                Denda::create([
                    'transaksi_id' => $transaction->id,
                    'jumlah_denda' => $jumlahDenda,
                    'hari_telat' => $hariTelat
                ]);
            }
        }

        // update transaksi
        $transaction->update([
            'tanggal_kembali' => $today,
            'status' => 'kembali'
        ]);

        // kembalikan stok
        $transaction->book->increment('stok');

        return back()->with(
            'success',
            $jumlahDenda > 0
                ? 'Buku dikembalikan. Denda: Rp ' . number_format($jumlahDenda)
                : 'Buku dikembalikan tanpa denda'
        );
    }
}
