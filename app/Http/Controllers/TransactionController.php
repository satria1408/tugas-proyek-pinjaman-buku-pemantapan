<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * ================= ADMIN =================
     */
    public function index()
    {
        $transactions = Transaction::with(['user', 'book'])->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $users = User::where('role', 'siswa')->get();
        $books = Book::where('stok', '>', 0)->get();

        return view('admin.transactions.create', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam|before_or_equal:' . Carbon::parse($request->tanggal_pinjam)->addDays(14)->toDateString(),
            'status' => 'required'
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stok < 1 && $request->status == 'pinjam') {
            return back()->with('error', 'Stok buku habis!');
        }

        Transaction::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'tanggal_pengembalian' => null,
            'status' => 'pinjam'
        ]);

        if ($request->status == 'pinjam') {
            $book->decrement('stok');
        }

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $users = User::where('role', 'siswa')->get();
        $books = Book::all();

        return view('admin.transactions.edit', compact('transaction', 'users', 'books'));
    }

    public function update(Request $request, string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $book = Book::findOrFail($transaction->book_id);

        $request->validate([
            'status' => 'required',
            'tanggal_pinjam' => 'required|date'
        ]);

        // pinjam → kembali
        if ($transaction->status == 'pinjam' && $request->status == 'kembali') {
            $book->increment('stok');

            $transaction->update([
                'status' => 'kembali',
                'tanggal_pengembalian' => Carbon::now()
            ]);

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Buku berhasil dikembalikan');
        }

        // kembali → pinjam lagi
        if ($transaction->status == 'kembali' && $request->status == 'pinjam') {
            if ($book->stok > 0) {
                $book->decrement('stok');

                $transaction->update([
                    'status' => 'pinjam',
                    'tanggal_pengembalian' => null
                ]);

                return redirect()->route('admin.transactions.index')
                    ->with('success', 'Status diubah ke pinjam lagi');
            } else {
                return back()->with('error', 'Stok tidak cukup!');
            }
        }

        return back()->with('info', 'Tidak ada perubahan status');
    }

    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status == 'pinjam') {
            $transaction->book->increment('stok');
        }

        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi dihapus');
    }


    /**
     * ================= SISWA =================
     */

    // Halaman konfirmasi pinjam
    public function createFromSiswa($book_id)
    {
        $book = Book::findOrFail($book_id);

        if ($book->stok <= 0) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Stok buku habis!');
        }

        return view('siswa.transaction', compact('book'));
    }

    // Simpan transaksi siswa
    public function storeFromSiswa(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam|before_or_equal:' . Carbon::parse($request->tanggal_pinjam)->addDays(7)->toDateString(),
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        Transaction::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'tanggal_pengembalian' => null,
            'status' => 'pinjam',
        ]);

        $book->decrement('stok');

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Buku berhasil dipinjam!');
    }
}