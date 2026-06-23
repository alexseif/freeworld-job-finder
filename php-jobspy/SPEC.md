# SPEC.md — php-jobspy

> **Version:** 1.0
> **Date:** 2026-06-23
> **Purpose:** Defines the goals, scope, constraints, and quality standards for the `php-jobspy` package. Agnostic to any specific LLM — readable by Aider, Cursor, Claude, or any assistant.

---

## 1. What This Package Is

`php-jobspy` is a **standalone, publishable PHP library** for aggregating job postings from public job boards into structured local data. It is inspired by the Python `jobspy` package and is designed to be:

- Dependency-light (Guzzle for HTTP, DOMDocument for parsing — no bloat)
- Pipeline-ready (outputs arrays consumable by downstream screeners)
- Agnostic to the job-finding orchestrator that calls it

It is **not** a web app, not a scraping service, and not an AI pipeline. It is a library.

### Relationship to Other Projects
- **freeworld-job-finder:** The orchestrator that uses this library. Lives in the parent directory.
- **alexseif.com:** Unrelated. This package reflects Alex's engineering skill but has no code connection to the portfolio site.

---

## 2. Current Capabilities

| Feature | Status |
|---|---|
| LinkedIn public SERP scraping | ✅ Implemented (auth-wall prone) |
| Job list export to CSV | ✅ Implemented |
| Job description deep-fetch | ❌ Placeholder string only |
| Unit tests for scraper | ❌ Not yet written |
| Indeed / Glassdoor support | ❌ Roadmap |

---

## 3. Immediate Work Item — Deep-Fetch

### Problem
`LinkedInScraper::scrape()` sets `'description' => 'Description omitted in public SERP list. Requires deep fetching.'` as a placeholder. The downstream `JobScreener` receives this string and sends it to the LLM. The AI is evaluating job titles only. Every screening decision is made blind.

### Solution
Add `fetchJobDescription(string $url): string` method to `LinkedInScraper`. Called optionally per job when `$args['deep_fetch'] === true`.

**Method contract:**
- Input: clean LinkedIn job URL (already normalized in scrape())
- Output: plain text job description, HTML-stripped
- On failure (auth wall, timeout, network): return `'Description unavailable.'` (silent fallback — no exception thrown)
- Polite delay: 500ms between deep-fetch requests via `usleep(500000)`

**LinkedIn DOM selectors to try (in order):**
1. `//div[contains(@class,'show-more-less-html__markup')]`
2. `//div[contains(@class,'description__text')]`
3. `//section[contains(@class,'core-section-container__content')]`

**Integration into `scrape()`:**
```php
if (!empty($args['deep_fetch'])) {
    $jobs[count($jobs)-1]['description'] = $this->fetchJobDescription($cleanUrl);
    usleep(500000);
}
```

**Config flag:** Document `deep_fetch: true/false` in `config/php-jobspy.yaml` as an opt-in.

---

## 4. Tech Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.1+ (strict_types) |
| HTTP Client | Guzzle 7 |
| HTML Parser | DOMDocument + DOMXPath (native PHP) |
| Config | symfony/yaml |
| Testing | PHPUnit |
| Package Manager | Composer |

**Constraint:** No new Composer dependencies without explicit approval.

---

## 5. Testing Standards

| Type | Command | Required For |
|---|---|---|
| Unit tests | `composer test` | Every commit |
| Static analysis | (future) PHPStan | Roadmap |

Tests use mock Guzzle clients — no live network calls in the test suite.

---

## 6. Code Style

- `declare(strict_types=1)` on every file
- PSR-4 autoloading: `Freeworld\PhpJobspy\`
- Methods return typed values — no `mixed` in new code
- Doc blocks on all public methods
- Silent failure over exception propagation for network-layer errors

---

## 7. Boundaries

### Always
- Keep this as a library — no HTTP endpoints, no CLI commands in this package
- Silent fallback on all network failures (never crash the calling pipeline)
- Polite rate limiting: 500ms minimum between HTTP requests

### Ask First
- Adding a new job board scraper (affects package scope)
- Changing the job array schema (breaks downstream CSV and screener)

### Never
- Store credentials or API keys in source code
- Add HTTP server capabilities
- Couple this package to `freeworld-job-finder` internal classes
