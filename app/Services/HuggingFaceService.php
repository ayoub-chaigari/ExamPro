<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HuggingFaceService
{
    /**
     * Rephrase text using Hugging Face Inference API.
     */
    public static function rephrase($text)
    {
        $apiKey = config('services.huggingface.key');

        if (!$apiKey) {
            return $text;
        }

        try {
            // Using a more standard model: t5-base
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
            ])->post('https://api-inference.huggingface.co/models/google-t5/t5-base', [
                'inputs' => "paraphrase: " . $text,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                // Hugging Face inference API returns an array of results
                $result = $data[0]['generated_text'] ?? $text;
                Log::info('HuggingFace Rephrased success: ' . $result);
                return $result;
            } else {
                Log::error('HuggingFace API error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('HuggingFace exception: ' . $e->getMessage());
        }

        return $text;
    }
}
