<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TranslatorController extends Controller
{
    public function index()
    {
        return view('open-translator');
    }

    public function translate(Request $request)
    {
        $text = urlencode($request->input('text'));
        $to = $request->input('to');
        $from = $request->input('from') ?? 'auto'; //if sourceLanguage is empty,set it to auto
        if (!$text || !$to) {
            return response()->json(['translatedText' => 'Missing parameters'], 400);
        }
        // unofficial Google Translate API endpoints-
        $data = "https://translate.googleapis.com/translate_a/single?client=gtx&sl={$from}&tl={$to}&dt=t&q={$text}";
        $response = file_get_contents($data);
        $decodedData = json_decode($response, true); //Decode JSON response to array-needed for php access
        // Extract translated text from nested array response
        $result = $decodedData[0][0][0] ?? 'Translation failed';
        return response()->json(['translatedText' => $result]); //encode to JSON to send back to js
    }
}
