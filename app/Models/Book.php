<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 
        'penulis', 
        'penerbit', 
        'kategori', 
        'stok'
    ];

    
    public function transactions() 
    {
        return $this->hasMany(Transaction::class);
    }

    public static function getRecommendations($userId)
    {
        // 1. Ambil kategori favorit user
        $favoriteCategory = Transaction::with('book')
            ->where('user_id', $userId)
            ->get()
            ->groupBy(function ($trx) {
                return $trx->book->kategori;
            })
            ->sortByDesc(function ($group) {
                return $group->count();
            })
            ->keys()
            ->first();

        // 2. Ambil buku rekomendasi dari kategori tersebut
        if ($favoriteCategory) {
            return self::where('kategori', $favoriteCategory)
                ->whereNotIn('id', function ($query) use ($userId) {
                    $query->select('book_id')
                          ->from('transactions')
                          ->where('user_id', $userId);
                })
                ->limit(5)
                ->get();
        }

        return collect(); 
    }
}