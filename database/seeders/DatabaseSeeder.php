<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. buat akun admin
        User::create([
            'username' => 'iyusadmin',
            'password' => Hash::make('123456'),
            'nama_lengkap' => 'Administrator Utama',
            'alamat' => 'ruang perpustakaan', // Samakan jadi kecil semua
            'role' => 'admin',
        ]);

        $siswa1 = User::create([
            'username' => 'toyjago',
            'password' => Hash::make('toy12345'),
            'nama_lengkap' => 'supertoy',
            'alamat' => 'Jl, abbys no. 6',
            'role' => 'siswa',
        ]);

        User::create([
            'username' => 'rinzzjago',
            'password' => Hash::make('123456'),
            'nama_lengkap' => 'super rinzz',
            'alamat' => 'jl, free fire no.1',
            'role' => 'siswa',
        ]);

        $buku1 = Book::create([
            'judul' => 'filosofi teras',
            'penulis' => 'alok',
            'penerbit' => 'kompas',
            'kategori' => 'pengembangan',
            'stok' => 10,
        ]);

        $buku2 = Book::create([
            'judul' => 'buku memasak', // Typo: mwmasak -> memasak
            'penulis' => 'rudi',
            'penerbit' => 'free fire',
            'kategori' => 'memasak',
            'stok' => 8,
        ]);

        // Perbaikan Titik Dua (::)
        Book::create([
            'judul' => 'ayam',
            'penulis' => 'alok',
            'penerbit' => 'ikan',
            'kategori' => 'pengembangan',
            'stok' => 4,
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
            'tanggal_kembali' => '2026-04-15', // Masih aman
            'status' => 'pinjam',
        ]);
    }
}
