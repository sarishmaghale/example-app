<?php

namespace App\Services;



class TranslationService
{

    public function translateText(string $text, string $to, string $from = 'auto'): string
    {
        $text = urlencode($text);
        $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl={$from}&tl={$to}&dt=t&q={$text}";

        try {
            $response = file_get_contents($url);
            $decoded = json_decode($response, true);
            return $decoded[0][0][0] ?? 'Translation failed';
        } catch (\Exception $e) {
            return 'Translation failed';
        }
    }
}
