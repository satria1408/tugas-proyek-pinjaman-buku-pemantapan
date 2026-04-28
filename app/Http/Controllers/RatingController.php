<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Simpan / update rating user ke buku
     */
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'book_id' => $bookId
            ],
            [
                'rating' => $request->rating
            ]
        );

        return back()->with('success', 'Rating berhasil dikirim');
    }
}