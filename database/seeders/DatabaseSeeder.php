<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
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
        ]);

        // 🟢 SISWA 1
        $siswa1 = User::create([
            'username' => 'toyjago',
            'email' => 'toyjago@gmail.com',
            'password' => Hash::make('toy12345'),
            'nama_lengkap' => 'supertoy',
            'alamat' => 'Jl. abbys no. 6',
            'role' => 'siswa',
        ]);

        // 🟢 SISWA 2
        $siswa2 = User::create([
            'username' => 'rinzzjago',
            'email' => 'rinzz@gmail.com',
            'password' => Hash::make('123456'),
            'nama_lengkap' => 'super rinzz',
            'alamat' => 'Jl. free fire no.1',
            'role' => 'siswa',
        ]);

        // 📚 BUKU
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
            'deskripsi' => 'Panduan memasak untuk pemula.',
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
            'deskripsi' => 'Panduan dasar beternak ayam.',
            'cover' => null,
            'negara' => 'Indonesia',
            'tanggal_rilis' => '2018-01-20'
        ]);

        // ⭐ RATING
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
            'user_id' => $siswa1->id,
            'book_id' => $buku2->id,
            'rating' => 4
        ]);

        Rating::create([
            'user_id' => $siswa1->id,
            'book_id' => $buku3->id,
            'rating' => 5
        ]);


        // 1. MASIH DIPINJAM & TERLAMBAT
        Transaction::create([
            'user_id' => $siswa1->id,
            'book_id' => $buku1->id,
            'tanggal_pinjam' => Carbon::now()->subDays(10),
            'tanggal_kembali' => Carbon::now()->subDays(3), // lewat deadline
            'tanggal_pengembalian' => null,
            'status' => 'pinjam',
        ]);
        $buku1->decrement('stok');


        // 2. SUDAH KEMBALI TEPAT WAKTU
        Transaction::create([
            'user_id' => $siswa1->id,
            'book_id' => $buku2->id,
            'tanggal_pinjam' => '2026-04-01',
            'tanggal_kembali' => '2026-04-08',
            'tanggal_pengembalian' => '2026-04-08',
            'status' => 'kembali',
        ]);


        //  3. SUDAH KEMBALI TERLAMBAT
        Transaction::create([
            'user_id' => $siswa2->id,
            'book_id' => $buku1->id,
            'tanggal_pinjam' => '2026-04-01',
            'tanggal_kembali' => '2026-04-08',
            'tanggal_pengembalian' => '2026-04-12', // telat 4 hari
            'status' => 'kembali',
        ]);


        Transaction::create([
            'user_id' => $siswa2->id,
            'book_id' => $buku3->id,
            'tanggal_pinjam' => Carbon::now()->subDays(2),
            'tanggal_kembali' => Carbon::now()->addDays(5),
            'tanggal_pengembalian' => null,
            'status' => 'pinjam',
        ]);
        $buku3->decrement('stok');
    }
}