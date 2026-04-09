<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() 
    {
        $books = Book::all();
        return view('admin.books.index', compact('books'));
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
