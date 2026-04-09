<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
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
            'tanggal_kembali' => ($request->status == 'kembali') ? Carbon::now() : null,
            'status' => $request->status
        ]);

        if ($request->status == 'pinjam') {
            $book->decrement('stok');
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan');
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

        if ($transaction->status == 'pinjam' && $request->status == 'kembali') {
            $book->increment('stok');
            $request->merge(['tanggal_kembali' => Carbon::now()]);
        }

        if ($transaction->status == 'kembali' && $request->status == 'pinjam') {
            if ($book->stok > 0) {
                $book->decrement('stok');
                $request->merge(['tanggal_kembali' => null]);
            } else {
                return back()->with('error', 'Stok tidak cukup untuk meminjam kembali.');
            }
        }

        $transaction->update($request->all());
        return redirect()->route('transactions.index')->with('success', 'Data transaksi diperbarui');
    }

    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        if ($transaction->status == 'pinjam') {
            $transaction->book->increment('stok');
        }
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi dihapus');
    }
}