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
        'stok',
        'halaman',     
        'deskripsi',   
        'cover',
        'content',   
        'rating',
        'negara',
        'tanggal_rilis'   
    ];

    // RELASI
    public function transactions() 
    {
        return $this->hasMany(Transaction::class);
    }

    // 🔥 OPTIONAL: FORMAT RATING (biar rapi 1 desimal)
    public function getRatingAttribute($value)
    {
        return number_format($value, 1);
    }

    // REKOMENDASI BUKU
    public static function getRecommendations($userId)
    {
        // Ambil kategori favorit user
        $favoriteCategory = Transaction::with('book')
            ->where('user_id', $userId)
            ->get()
            ->filter(function ($trx) {
                return $trx->book !== null; 
            })
            ->groupBy(function ($trx) {
                return $trx->book->kategori;
            })
            ->sortByDesc(function ($group) {
                return $group->count();
            })
            ->keys()
            ->first();

        // Ambil buku rekomendasi
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
    public function ratings() {
    return $this->hasMany(\App\Models\Rating::class);
   }
}