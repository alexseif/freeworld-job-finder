<?php

declare(strict_types=1);

namespace FreeworldJobFinder\Screener\Adapters;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OllamaAdapter implements LlmAdapterInterface
{
    private Client $client;
    private string $baseUri;
    private string $model;

    public function __construct(array $config)
    {
        $this->client = new Client(['timeout' => 60.0]); // Local inference can be slow
        $this->baseUri = $config['ollama']['base_uri'] ?? 'http://localhost:11434/api/generate';
        $this->model = $config['model'] ?? 'llama3';
    }

    public function evaluateJob(string $title, string $description, string $systemPrompt): bool
    {
        $prompt = sprintf(
            "Job Title: %s\nJob Description: %s\n\nTask: Evaluate the job based on the system criteria. Reply ONLY with the exact word 'YES' if it is a strong match, or 'NO' if it is not.",
            $title,
            $description
        );
        
        try {
            $response = $this->client->post($this->baseUri, [
                'json' => [
                    'model' => $this->model,
                    'system' => $systemPrompt,
                    'prompt' => $prompt,
                    'stream' => false,
                ]
            ]);
            
            $data = json_decode((string) $response->getBody(), true);
            $reply = trim(strtoupper($data['response'] ?? 'NO'));
            
            return str_contains($reply, 'YES');
        } catch (GuzzleException $e) {
            echo "Ollama API Error: " . $e->getMessage() . "\n";
            return false;
        }
    }
}
