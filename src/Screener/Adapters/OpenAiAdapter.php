<?php

declare(strict_types=1);

namespace FreeworldJobFinder\Screener\Adapters;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OpenAiAdapter implements LlmAdapterInterface
{
    private Client $client;
    private string $apiKey;
    private string $model;

    public function __construct(array $config)
    {
        $this->client = new Client(['timeout' => 30.0]);
        $this->apiKey = $config['openai']['api_key'] ?? '';
        $this->model = $config['model'] ?? 'gpt-4o-mini';
        
        if (empty($this->apiKey) || $this->apiKey === 'YOUR_OPENAI_API_KEY') {
            throw new \InvalidArgumentException("OpenAI API Key is missing or invalid in the configuration.");
        }
    }

    public function evaluateJob(string $title, string $description, string $systemPrompt): bool
    {
        $userMessage = sprintf(
            "Job Title: %s\nJob Description: %s\n\nTask: Evaluate the job based on the system criteria. Reply ONLY with the exact word 'YES' if it is a strong match, or 'NO' if it is not.",
            $title,
            $description
        );
        
        try {
            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                    'temperature' => 0.0,
                    'max_tokens' => 10,
                ]
            ]);
            
            $data = json_decode((string) $response->getBody(), true);
            $reply = trim(strtoupper($data['choices'][0]['message']['content'] ?? 'NO'));
            
            return str_contains($reply, 'YES');
        } catch (GuzzleException $e) {
            echo "OpenAI API Error: " . $e->getMessage() . "\n";
            return false;
        }
    }
}
