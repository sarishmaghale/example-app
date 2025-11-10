<?php

namespace App\Http\Controllers;

use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TranslatorController extends Controller
{
    protected $translationService;
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    public function index()
    {
        return view('open-translator');
    }

    public function translate(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'text' => 'required|string',
            'to' => 'required|string',
            'from' => 'nullable|string',
        ]);

        // Call the service
        $translatedText = $this->translationService->translateText(
            $validated['text'],
            $validated['to'],
            $validated['from'] ?? 'auto'
        );

        // Return JSON response
        return response()->json(['translatedText' => $translatedText]);
    }
}
