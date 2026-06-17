<?php

/**
 * Llama Screening Script
 * 
 * Evaluates scraped job descriptions using a local Llama instance
 * to classify if they are a match based on specific technical requirements.
 * Adheres to PSR-12 standards.
 */

declare(strict_types=1);

namespace FreeworldJobFinder\Scripts;

class LlamaScreener
{
    private const LOCAL_LLAMA_URL = 'http://localhost:11434/api/generate';

    /**
     * Main function to read raw jobs, screen them, and save the results.
     */
    public function run(): void
    {
        $inputFile = __DIR__ . '/../raw_netherlands_jobs.csv';
        $outputFile = __DIR__ . '/../screened_jobs.csv';

        if (!file_exists($inputFile)) {
            echo "Error: 'raw_netherlands_jobs.csv' not found. Please run fetch_jobs.php first.\n";
            return;
        }

        echo "Screening jobs with local Llama instance...\n";

        $inputHandle = fopen($inputFile, 'r');
        $outputHandle = fopen($outputFile, 'w');

        if ($inputHandle === false || $outputHandle === false) {
            echo "Error: Could not open files for reading/writing.\n";
            return;
        }

        // Read headers
        $headers = fgetcsv($inputHandle);
        if ($headers === false) {
            echo "Error: CSV is empty or invalid.\n";
            return;
        }

        // Add the new column header
        $headers[] = 'Llama_Verdict';
        fputcsv($outputHandle, $headers);

        $descriptionIndex = array_search('description', $headers);
        if ($descriptionIndex === false) {
            $descriptionIndex = 3; // Fallback index
        }

        while (($row = fgetcsv($inputHandle)) !== false) {
            $description = $row[$descriptionIndex] ?? '';
            $verdict = $this->evaluateJob((string)$description);
            $row[] = $verdict;
            fputcsv($outputHandle, $row);
        }

        fclose($inputHandle);
        fclose($outputHandle);

        echo "Screening complete. Review 'screened_jobs.csv'.\n";
    }

    /**
     * Evaluates a job description against a strict technical profile using local Llama.
     * 
     * @param string $description The raw job description text.
     * @return string "MATCH", "BYPASS", or "ERROR"
     */
    private function evaluateJob(string $description): string
    {
        $prompt = <<<EOT
You are a strict technical recruiter vetting candidates.
Candidate profile: 20+ years experience, expert in PHP, Symfony, and backend MySQL database design.

Job Description:
{$description}

Task: Does this job explicitly require senior-level PHP or backend architecture? 
Respond with exactly one word: "MATCH" or "BYPASS". Do not write an explanation.
EOT;

        $payload = json_encode([
            'model' => 'llama3',
            'prompt' => $prompt,
            'stream' => false
        ]);

        $ch = curl_init(self::LOCAL_LLAMA_URL);
        if ($ch === false) {
             return "ERROR";
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 30 second timeout

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($response === false || $httpCode !== 200) {
            echo "Error evaluating description: cURL error: {$error}, HTTP code: {$httpCode}\n";
            return "ERROR";
        }

        $result = json_decode((string)$response, true);
        return trim($result['response'] ?? 'ERROR');
    }
}

// Execute the script
$screener = new LlamaScreener();
$screener->run();
