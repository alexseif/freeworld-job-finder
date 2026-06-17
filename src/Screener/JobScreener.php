<?php

declare(strict_types=1);

namespace FreeworldJobFinder\Screener;

use FreeworldJobFinder\Screener\Adapters\LlmAdapterInterface;
use FreeworldJobFinder\Screener\Adapters\OllamaAdapter;
use FreeworldJobFinder\Screener\Adapters\OpenAiAdapter;
use FreeworldJobFinder\Screener\Adapters\AnthropicAdapter;
use Symfony\Component\Yaml\Yaml;

class JobScreener
{
    private LlmAdapterInterface $adapter;
    private array $config;

    public function __construct()
    {
        $configPath = __DIR__ . '/../../config/php-jobspy.yaml';
        if (!file_exists($configPath)) {
            throw new \RuntimeException(sprintf("Config file not found at %s", $configPath));
        }

        $fullConfig = Yaml::parseFile($configPath);
        $this->config = $fullConfig['screener'] ?? [];

        if (empty($this->config)) {
            throw new \RuntimeException("Missing 'screener' configuration block in php-jobspy.yaml.");
        }

        $provider = strtolower($this->config['provider'] ?? 'ollama');

        $this->adapter = match ($provider) {
            'openai' => new OpenAiAdapter($this->config),
            'anthropic' => new AnthropicAdapter($this->config),
            'ollama' => new OllamaAdapter($this->config),
            default => throw new \InvalidArgumentException("Unsupported LLM provider: {$provider}"),
        };
    }

    public function run(string $inputCsv, string $outputCsv): void
    {
        if (!file_exists($inputCsv)) {
            echo "Input CSV not found: {$inputCsv}\n";
            return;
        }

        echo sprintf("Starting AI Screening using provider: %s (Model: %s)\n", $this->config['provider'], $this->config['model']);
        
        $systemPrompt = $this->config['system_prompt'] ?? 'You are a highly analytical AI recruiter. Your job is to strictly evaluate job descriptions against a set of predefined requirements.';
        
        $handle = fopen($inputCsv, 'r');
        $outputHandle = fopen($outputCsv, 'w');
        
        $headers = fgetcsv($handle);
        if ($headers) {
            // Add an 'AI_Match' column
            $headers[] = 'ai_match';
            fputcsv($outputHandle, $headers);
        }

        $processed = 0;
        $matches = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (count($headers) > count($row)) {
                $row = array_pad($row, count($headers) - 1, '');
            }
            $data = array_combine(array_slice($headers, 0, count($row)), $row);
            
            $title = $data['title'] ?? '';
            $description = $data['description'] ?? '';

            // Basic filtering before expensive LLM call
            if (empty($title) || $title === 'Unknown Title') {
                continue;
            }

            echo "Evaluating: {$title}... ";
            $isMatch = $this->adapter->evaluateJob($title, $description, $systemPrompt);
            
            if ($isMatch) {
                echo "[YES]\n";
                $row[] = 'YES';
                fputcsv($outputHandle, $row);
                $matches++;
            } else {
                echo "[NO]\n";
            }
            
            $processed++;
        }

        fclose($handle);
        fclose($outputHandle);

        echo sprintf("\nScreening complete! Processed %d jobs. Found %d matches. Saved to %s.\n", $processed, $matches, $outputCsv);
    }
}
