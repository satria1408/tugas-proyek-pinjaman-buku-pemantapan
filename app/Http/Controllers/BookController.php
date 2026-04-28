<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request) 
    {
        $query = Book::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $books = $query->get();

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
            'halaman' => 'nullable|integer|min:1',
            'deskripsi' => 'nullable',
            'negara' => 'nullable|string|max:100',
            'tanggal_rilis' => 'nullable|date',

            'cover' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $filePath = null;

        if ($request->hasFile('cover')) {
            $filePath = $request->file('cover')->store('covers', 'public');
        }

        Book::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'halaman' => $request->halaman,
            'deskripsi' => $request->deskripsi,
            'negara' => $request->negara,
            'tanggal_rilis' => $request->tanggal_rilis,

            'cover' => $filePath
        ]);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function show($id)
    {
        $book = Book::with('ratings')->findOrFail($id);
        return view('admin.books.show', compact('book'));
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
            'halaman' => 'nullable|integer|min:1',
            'deskripsi' => 'nullable',
            'negara' => 'nullable|string|max:100',
            'tanggal_rilis' => 'nullable|date',

            'cover' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $book = Book::findOrFail($id);

        $filePath = $book->cover;

        if ($request->hasFile('cover')) {

            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            $filePath = $request->file('cover')->store('covers', 'public');
        }

        $book->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'halaman' => $request->halaman,
            'deskripsi' => $request->deskripsi,
            'negara' => $request->negara,
            'tanggal_rilis' => $request->tanggal_rilis,

            'cover' => $filePath
        ]);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($id) 
    {
        $book = Book::findOrFail($id);

        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus');
    }
}