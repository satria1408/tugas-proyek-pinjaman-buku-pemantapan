<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    public function index()
{
    $userId = Auth::id() ?? 1;

    $recommended = Book::getRecommendations($userId);

    $popular = Book::withCount('transactions')
        ->orderByDesc('transactions_count')
        ->limit(5)
        ->get();

    $latest = Book::latest('id') 
        ->limit(5)
        ->get();

    return view('siswa.dashboard', compact('recommended', 'popular', 'latest'));
}
}
