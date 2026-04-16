<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request) 
    {
        $query = Book::query();

        // 🔍 FILTER KATEGORI
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // 🔎 SEARCH
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $books = $query->get();

        // ambil kategori unik untuk dropdown
        $categories = Book::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create() 
    {
        $categories = Book::select('kategori')->distinct()->pluck('kategori');
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'kategori' => 'required',
            'stok' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $filePath = null;

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/covers', $fileName);

            $filePath = 'covers/' . $fileName;
        }

        Book::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'cover' => $filePath
        ]);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit($id) 
    {
        $book = Book::findOrFail($id);
        $categories = Book::select('kategori')->distinct()->pluck('kategori');

        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, $id) 
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'kategori' => 'required',
            'stok' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $book = Book::findOrFail($id);

        $filePath = $book->cover;

        if ($request->hasFile('cover')) {

            // hapus gambar lama
            if ($book->cover && file_exists(storage_path('app/public/' . $book->cover))) {
                unlink(storage_path('app/public/' . $book->cover));
            }

            $file = $request->file('cover');
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/covers', $fileName);

            $filePath = 'covers/' . $fileName;
        }

        $book->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'cover' => $filePath
        ]);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($id) 
    {
        $book = Book::findOrFail($id);

        // hapus gambar jika ada
        if ($book->cover && file_exists(storage_path('app/public/' . $book->cover))) {
            unlink(storage_path('app/public/' . $book->cover));
        }

        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus');
    }
}