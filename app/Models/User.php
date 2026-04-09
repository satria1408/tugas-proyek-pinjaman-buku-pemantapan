<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi massal.
     */
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'alamat',
        'role',
    ];

    /**
     * Relasi ke model Transaction.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Atribut yang disembunyikan untuk keamanan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
