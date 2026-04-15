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
            'stok' => 'required|integer'
        ]);

        Book::create($request->only([
            'judul',
            'penulis',
            'penerbit',
            'kategori',
            'stok'
        ]));

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
            'stok' => 'required|integer'
        ]);

        $book = Book::findOrFail($id);

        $book->update($request->only([
            'judul',
            'penulis',
            'penerbit',
            'kategori',
            'stok'
        ]));

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($id) 
    {
        Book::findOrFail($id)->delete();
        

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil dihapus');
    }
}