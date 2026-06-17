<?php

declare(strict_types=1);

namespace FreeworldJobFinder\Screener\Adapters;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AnthropicAdapter implements LlmAdapterInterface
{
    private Client $client;
    private string $apiKey;
    private string $model;

    public function __construct(array $config)
    {
        $this->client = new Client(['timeout' => 30.0]);
        $this->apiKey = $config['anthropic']['api_key'] ?? '';
        $this->model = $config['model'] ?? 'claude-3-haiku-20240307';
        
        if (empty($this->apiKey) || $this->apiKey === 'YOUR_ANTHROPIC_API_KEY') {
            throw new \InvalidArgumentException("Anthropic API Key is missing or invalid in the configuration.");
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
            $response = $this->client->post('https://api.anthropic.com/v1/messages', [
                'headers' => [
                    'x-api-key' => $this->apiKey,
                    'anthropic-version' => '2023-06-01',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $this->model,
                    'system' => $systemPrompt,
                    'messages' => [
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                    'temperature' => 0.0,
                    'max_tokens' => 10,
                ]
            ]);
            
            $data = json_decode((string) $response->getBody(), true);
            $reply = trim(strtoupper($data['content'][0]['text'] ?? 'NO'));
            
            return str_contains($reply, 'YES');
        } catch (GuzzleException $e) {
            echo "Anthropic API Error: " . $e->getMessage() . "\n";
            return false;
        }
    }
}
