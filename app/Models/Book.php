<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi massal.
     *
     * @var array
     */
    protected $fillable = [
        'judul', 
        'penulis', 
        'penerbit', 
        'kategori', 
        'stok'
    ];

    /**
     * Relasi ke model Transaction (Satu buku bisa punya banyak transaksi).
     */
    public function transactions() 
    {
        return $this->hasMany(Transaction::class);
    }
}