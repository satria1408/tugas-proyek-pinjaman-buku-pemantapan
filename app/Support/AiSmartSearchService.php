<?php

namespace App\Support;

use App\Support\GeminiService;

class AiSmartSearchService
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function rankBooks($books, $query)
    {
        $text = "";

        foreach ($books as $book) {
            $text .= "Judul: {$book->judul}, Penulis: {$book->penulis}, Kategori: {$book->kategori}, Deskripsi: {$book->deskripsi}\n";
        }

        $prompt = "
        Kamu adalah AI perpustakaan.

        Berikut daftar buku:
        $text

        Query user: $query

        Pilih maksimal 5 buku paling relevan.
        Jawab hanya dengan judul buku.
        ";

        $response = $this->gemini->ask($prompt);

        return $response['candidates'][0]['content']['parts'][0]['text'] ?? null;
    }
}