<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    public function ask($prompt)
    {
        $apiKey = env('GEMINI_API_KEY');

        $response = Http::post(
            "https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=$apiKey",
            [
                "contents" => [
                    [
                        "parts" => [
                            ["text" => $prompt]
                        ]
                    ]
                ]
            ]
        );

        return $response->json();
    }
}