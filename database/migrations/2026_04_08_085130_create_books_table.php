<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit');
            $table->string('kategori');
            $table->integer('stok');
            $table->integer('halaman')->nullable();
            $table->text('deskripsi')->nullable();
            $table->longText('content')->nullable();
            $table->float('rating')->default(0);
            $table->string('cover')->nullable();
            $table->string('negara')->nullable();
            $table->date('tanggal_rilis')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};