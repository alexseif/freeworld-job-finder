<?php

declare(strict_types=1);

namespace FreeworldJobFinder\Screener\Adapters;

interface LlmAdapterInterface
{
    /**
     * Evaluates a job listing and returns true if it matches the criteria, false otherwise.
     *
     * @param string $title
     * @param string $description
     * @param string $systemPrompt
     * @return bool
     */
    public function evaluateJob(string $title, string $description, string $systemPrompt): bool;
}
