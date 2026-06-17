<?php

declare(strict_types=1);

namespace FreeworldJobFinder\Fetcher;

use Freeworld\PhpJobspy\Jobspy;
use Symfony\Component\Yaml\Yaml;

class JobFetcher
{
    public function run(): void
    {
        try {
            echo "Initializing php-jobspy...\n";
            
            $configPath = __DIR__ . '/../../config/php-jobspy.yaml';
            if (!file_exists($configPath)) {
                throw new \RuntimeException(sprintf("Config file not found at %s", $configPath));
            }
            
            $configRaw = Yaml::parseFile($configPath);
            $config = $configRaw['php_jobspy'] ?? [];
            
            if (empty($config)) {
                throw new \RuntimeException("Invalid or missing 'php_jobspy' key in config file.");
            }
            
            $spy = new Jobspy();
            $jobs = $spy->scrapeJobs($config);

            // Save outside the package root
            $outputFile = __DIR__ . '/../../raw_netherlands_jobs.csv';
            $spy->exportToCsv($jobs, $outputFile);
            
            echo sprintf("Successfully scraped %d jobs and saved to %s.\n", count($jobs), realpath($outputFile));
            
        } catch (\Exception $e) {
            echo sprintf("An error occurred during scraping: %s\n", $e->getMessage());
        }
    }
}
