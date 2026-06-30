<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class ChatbotTextToSpeech
{
    public function enabled(): bool
    {
        return (bool) config('services.chatbot_tts.enabled')
            && filled(config('services.chatbot_tts.openai.api_key'));
    }

    public function speak(string $text, string $language): string
    {
        if (! $this->enabled()) {
            throw new RuntimeException('Chatbot TTS is not configured.');
        }

        $text = trim(strip_tags($text));
        if ($text === '') {
            throw new RuntimeException('No text was provided for TTS.');
        }

        $baseUrl = rtrim((string) config('services.chatbot_tts.openai.base_url'), '/');
        $voice = $language === 'hi'
            ? (string) config('services.chatbot_tts.openai.voice_hi')
            : (string) config('services.chatbot_tts.openai.voice_en');

        $response = Http::withToken((string) config('services.chatbot_tts.openai.api_key'))
            ->accept('audio/mpeg')
            ->timeout((int) config('services.chatbot_tts.timeout', 30))
            ->post($baseUrl.'/audio/speech', [
                'model' => (string) config('services.chatbot_tts.openai.model'),
                'voice' => $voice,
                'input' => $text,
                'response_format' => 'mp3',
            ]);

        if ($response->failed() || blank($response->body())) {
            throw new RuntimeException('TTS provider failed to generate audio.');
        }

        return $response->body();
    }
}
