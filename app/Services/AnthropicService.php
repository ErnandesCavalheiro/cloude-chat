<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AnthropicService 
{
    private string $baseUrl;
    private string $apiKey;
    private const MAX_TOKENS = 1024;
    private const DEFAULT_MODEL = 'claude-3-opus-20240229';

    public function __construct()
    {
        $this->baseUrl = env('ANTHROPIC_BASE_URL');
        $this->apiKey = env('ANTHROPIC_API_TOKEN');
    }

    public function createMessage(string $content, mixed $history = null): array
    {
        $url = $this->baseUrl . '/v1/messages';

        Log::debug(json_encode($history));

        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'anthropic-version' => '2023-06-01'
        ])->post($url, [
            'messages' => $history,
            'model' => self::DEFAULT_MODEL,
            'max_tokens' => self::MAX_TOKENS
        ]);

        return json_decode($response->body(), true);
    }

    public function getMessageContent(array $message): string
    {
        return Str::ascii($message['content'][0]['text']);
    }
}
