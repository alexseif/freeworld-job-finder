<?php

declare(strict_types=1);

namespace FreeworldJobFinder\Fetcher;

use Freeworld\PhpJobspy\Jobspy;

class JobFetcher
{
    public function run(): void
    {
        try {
            echo "Initializing php-jobspy...\n";
            
            $spy = new Jobspy();
            $jobs = $spy->scrapeJobs([
                'site_name' => ['linkedin', 'indeed'],
                'search_term' => 'Senior PHP Developer',
                'location' => 'Netherlands',
                'results_wanted' => 20,
                'hours_old' => 72,
                'country_integrity' => 'netherlands'
            ]);

            // Save outside the package root
            $outputFile = __DIR__ . '/../../raw_netherlands_jobs.csv';
            $spy->exportToCsv($jobs, $outputFile);
            
            echo sprintf("Successfully scraped %d jobs and saved to %s.\n", count($jobs), realpath($outputFile));
            
        } catch (\Exception $e) {
            echo sprintf("An error occurred during scraping: %s\n", $e->getMessage());
        }
    }
}
