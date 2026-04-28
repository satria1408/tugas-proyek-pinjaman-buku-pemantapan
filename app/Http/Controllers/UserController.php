<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ================= DASHBOARD =================
     */
    public function dashboard(Request $request)
    {
        // 🔴 ADMIN
        if (Auth::user()->role === 'admin') {
            $users = User::count();
            $books = Book::count();

            return view('admin.dashboard', compact('users', 'books'));
        }

        // 🟢 SISWA
        $query = Book::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $books = $query->get();

        $categories = Book::select('kategori')->distinct()->pluck('kategori');

        $myBooks = Transaction::with('book')
            ->where('user_id', Auth::id())
            ->get();

        return view('siswa.dashboard', compact('books', 'categories', 'myBooks'));
    }

    /**
     * ================= PINJAM BUKU =================
     */
    public function pinjamBuku($book_id)
    {
        $book = Book::findOrFail($book_id);

        if ($book->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        Transaction::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'tanggal_pinjam' => now(),
            'status' => 'pinjam',
        ]);

        $book->decrement('stok');

        return back()->with('success', 'Buku berhasil dipinjam');
    }

    /**
     * ================= KEMBALIKAN =================
     */
    public function kembalikanBuku($transaction_id)
    {
        $trans = Transaction::findOrFail($transaction_id);

        if ($trans->status == 'kembali') {
            return back()->with('error', 'Buku sudah dikembalikan');
        }

        $trans->update([
            'status' => 'kembali',
            'tanggal_kembali' => now(),
        ]);

        $trans->book->increment('stok');

        return back()->with('success', 'Buku berhasil dikembalikan');
    }

    /**
     * ================= HAPUS TRANSAKSI =================
     */
    public function destroyTransaction($id)
    {
        $trans = Transaction::findOrFail($id);
        $trans->delete();

        return back()->with('success', 'Transaksi dihapus');
    }

    /**
     * ================= ADMIN: LIST USER =================
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * ================= ADMIN: CREATE =================
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * ================= ADMIN: STORE =================
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'nullable|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6',
            'alamat' => 'nullable',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'role' => 'siswa',
            'provider' => null,
            'provider_id' => null
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Anggota berhasil ditambahkan');
    }

    /**
     * ================= ADMIN: EDIT =================
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * ================= ADMIN: UPDATE =================
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'nullable|unique:users,username,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'alamat' => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data anggota diperbarui');
    }

    /**
     * ================= ADMIN: DELETE =================
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error', 'Admin tidak boleh dihapus!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Anggota berhasil dihapus');
    }
}