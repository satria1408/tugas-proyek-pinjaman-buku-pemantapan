<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 🔴 ADMIN
        $admin = User::create([
            'username' => 'iyusadmin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'nama_lengkap' => 'Administrator Utama',
            'alamat' => 'ruang perpustakaan',
            'role' => 'admin',
            'provider' => null,
            'provider_id' => null
        ]);

        // 🟢 SISWA 1
        $siswa1 = User::create([
            'username' => 'toyjago',
            'email' => 'toyjago@gmail.com',
            'password' => Hash::make('toy12345'),
            'nama_lengkap' => 'supertoy',
            'alamat' => 'Jl, abbys no. 6',
            'role' => 'siswa',
            'provider' => null,
            'provider_id' => null
        ]);

        // 🟢 SISWA 2
        $siswa2 = User::create([
            'username' => 'rinzzjago',
            'email' => 'rinzz@gmail.com',
            'password' => Hash::make('123456'),
            'nama_lengkap' => 'super rinzz',
            'alamat' => 'jl, free fire no.1',
            'role' => 'siswa',
            'provider' => null,
            'provider_id' => null
        ]);

        $buku1 = Book::create([
    'judul' => 'Filosofi Teras',
    'penulis' => 'Alok',
    'penerbit' => 'Kompas',
    'kategori' => 'Pengembangan',
    'stok' => 10,
    'halaman' => 320,
    'deskripsi' => 'Buku tentang filosofi stoik untuk kehidupan sehari-hari.',
    'cover' => null,
    'negara' => 'Indonesia',
    'tanggal_rilis' => '2019-03-15'
]);

$buku2 = Book::create([
    'judul' => 'Buku Memasak',
    'penulis' => 'Rudi',
    'penerbit' => 'Kitchen Press',
    'kategori' => 'Memasak',
    'stok' => 8,
    'halaman' => 150,
    'deskripsi' => 'Panduan memasak untuk pemula dengan resep sederhana.',
    'cover' => null,
    'negara' => 'Indonesia',
    'tanggal_rilis' => '2020-06-10'
]);

$buku3 = Book::create([
    'judul' => 'Belajar Ayam',
    'penulis' => 'Alok',
    'penerbit' => 'Peternakan',
    'kategori' => 'Pengembangan',
    'stok' => 4,
    'halaman' => 90,
    'deskripsi' => 'Panduan dasar beternak ayam untuk pemula.',
    'cover' => null,
    'negara' => 'Indonesia',
    'tanggal_rilis' => '2018-01-20'
]);

        Rating::create([
            'user_id' => $siswa1->id,
            'book_id' => $buku1->id,
            'rating' => 5
        ]);

        Rating::create([
            'user_id' => $siswa2->id,
            'book_id' => $buku1->id,
            'rating' => 4
        ]);

        Rating::create([
            'user_id' => $admin->id,
            'book_id' => $buku1->id,
            'rating' => 3
        ]);

        
        Rating::create([
            'user_id' => $siswa1->id,
            'book_id' => $buku2->id,
            'rating' => 4
        ]);

        
        Rating::create([
            'user_id' => $siswa1->id,
            'book_id' => $buku3->id,
            'rating' => 5
        ]);

        Rating::create([
            'user_id' => $siswa2->id,
            'book_id' => $buku3->id,
            'rating' => 4
        ]);

        Transaction::create([
            'user_id' => $siswa1->id,
            'book_id' => $buku1->id,
            'tanggal_pinjam' => Carbon::now()->subDays(2),
            'tanggal_kembali' => '2024-04-10',
            'status' => 'pinjam',
        ]);

        $buku1->decrement('stok');

        Transaction::create([
            'user_id' => $siswa1->id,
            'book_id' => $buku2->id,
            'tanggal_pinjam' => '2024-04-06',
            'tanggal_kembali' => '2024-04-13',
            'status' => 'kembali',
        ]);

        Transaction::create([
            'user_id' => $siswa1->id,
            'book_id' => $buku1->id,
            'tanggal_pinjam' => '2026-04-01',
            'tanggal_kembali' => '2026-04-08',
            'status' => 'pinjam',
        ]);

        Transaction::create([
            'user_id' => $siswa1->id,
            'book_id' => $buku2->id,
            'tanggal_pinjam' => '2026-04-08',
            'tanggal_kembali' => '2026-04-15',
            'status' => 'pinjam',
        ]);
    }
}