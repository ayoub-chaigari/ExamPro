<?php

namespace App\Services;

use App\Services\HuggingFaceService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    /**
     * Rephrase a question using OpenAI.
     * This is a stub implementation. You will need a valid OPENAI_API_KEY in .env.
     */
    public static function rephrase($text)
    {
        $apiKey = env('OPENAI_API_KEY');

        if (!$apiKey) {
            return $text; // Fallback to original if no API key
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Rephrase the given exam question. YOU MUST CHANGE THE WORDS and STRUCTURE while keeping the exact same meaning. DO NOT return the same sentence. Be creative but professional.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $text
                    ]
                ],
                'temperature' => 0.8,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $result = $data['choices'][0]['message']['content'] ?? $text;
                Log::info('OpenAI Rephrased success: ' . $result);
                return $result;
            } else {
                Log::warning('OpenAI API error, falling back to HuggingFace: ' . $response->body());
                return HuggingFaceService::rephrase($text);
            }
        } catch (\Exception $e) {
            Log::error('OpenAI exception, falling back to HuggingFace: ' . $e->getMessage());
            return HuggingFaceService::rephrase($text);
        }

        return $text;
    }
}
