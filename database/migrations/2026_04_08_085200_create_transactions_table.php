<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');

            $table->date('tanggal_pinjam');

            // ✅ DEADLINE (dipilih user)
            $table->date('tanggal_kembali');

            // ✅ TANGGAL REAL BALIK
            $table->date('tanggal_pengembalian')->nullable();

            $table->enum('status', ['pinjam', 'kembali']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};