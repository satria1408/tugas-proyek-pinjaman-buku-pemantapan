<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request) 
    {
        $query = Book::query();

        
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        
        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $books = $query->get();

    
        $categories = Book::select('kategori')->distinct()->pluck('kategori');

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create() 
    {
        return view('admin.books.create');
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

        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit($id) 
    {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
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
        $book->update($request->all());
        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($id) 
    {
        Book::findOrFail($id)->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus');
    }
}