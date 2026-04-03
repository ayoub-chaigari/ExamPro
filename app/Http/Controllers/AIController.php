<?php

namespace App\Http\Controllers;

use App\Services\HuggingFaceService;
use Illuminate\Http\Request;

class AIController extends Controller
{
    /**
     * Test Hugging Face AI.
     */
    public function test()
    {
        $text = "Hello world";
        $rephrased = HuggingFaceService::rephrase($text);

        return response()->json([
            'original' => $text,
            'rephrased' => $rephrased,
            'status' => 'success'
        ]);
    }
}
