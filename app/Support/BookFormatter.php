<?php

namespace App\Support;

use Illuminate\Support\Collection;

class BookFormatter
{
    /**
     * Format collection buku menjadi text untuk AI (Gemini)
     */
    public static function toAiText(Collection $books): string
    {
        return $books->map(function ($book, $index) {
            return ($index + 1) . ". " . self::formatSingle($book);
        })->implode("\n");
    }

    /**
     * Format satu buku
     */
    public static function formatSingle($book): string
    {
        return "Judul: {$book->judul}, "
            . "Penulis: {$book->penulis}, "
            . "Kategori: {$book->kategori}, "
            . "Deskripsi: " . self::limitText($book->deskripsi, 150);
    }

    /**
     * Batasi panjang text biar tidak kepanjangan ke AI
     */
    public static function limitText(?string $text, int $limit = 150): string
    {
        if (!$text) {
            return '-';
        }

        return strlen($text) > $limit
            ? substr($text, 0, $limit) . '...'
            : $text;
    }

    /**
     * (Opsional) Ambil hanya judul buku dari response AI
     */
    public static function extractTitles(string $aiText): array
    {
        $lines = explode("\n", $aiText);

        return collect($lines)
            ->map(function ($line) {
                // hapus nomor "1. ", "2. ", dll
                return trim(preg_replace('/^\d+\.\s*/', '', $line));
            })
            ->filter()
            ->values()
            ->toArray();
    }
}