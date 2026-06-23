# Plan — php-jobspy
> Spec: SPEC.md | Updated: 2026-06-23
> This file covers ONLY php-jobspy tasks. alexseif.com has its own plan.

---

## Open Decision (Block execution until answered)

### Q1 — Deep-Fetch Failure Mode

When LinkedIn blocks a description fetch (auth wall, timeout, HTTP error), what should `fetchJobDescription()` do?

| | Path A: Silent Fallback | Path B: Throw DeepFetchException |
|---|---|---|
| **Behaviour** | Returns `'Description unavailable.'` string. Pipeline continues. | Throws `DeepFetchException`. Orchestrator decides: skip, retry, or abort. |
| **Pros** | Pipeline never crashes. Screener still runs on title alone for that job. Simpler — no new exception class. | Caller has full control. Can implement retry logic. Failure is explicit in logs. |
| **Cons** | Silent failures are invisible. Screener may produce false positives on jobs with no description. | Requires orchestrator (`JobFetcher.php`) to handle the exception — more code in the caller. |
| **Best for** | Batch runs where partial data is acceptable. | Systems where every job must have a description or be explicitly skipped. |

---

## Dependency Order

```
[Q1] P-01 Deep-Fetch Implementation → P-02 Unit Test → update config docs
```

---

## Tasks

### P-01: LinkedIn Deep-Fetch Method
**Status:** Blocked on Q1 (failure mode decision)
**File:** `src/Scrapers/LinkedInScraper.php`

**New method:** `fetchJobDescription(string $url): string`
- Makes GET request to individual job URL using same Guzzle client config
- Tries selectors in order:
  1. `//div[contains(@class,'show-more-less-html__markup')]`
  2. `//div[contains(@class,'description__text')]`
  3. `//section[contains(@class,'core-section-container__content')]`
- Returns `strip_tags($node->textContent)` trimmed
- On any failure: Path A returns `'Description unavailable.'` / Path B throws `DeepFetchException`

**Modify `scrape()`:** Add opt-in flag:
```php
if (!empty($args['deep_fetch'])) {
    $jobs[count($jobs)-1]['description'] = $this->fetchJobDescription($cleanUrl);
    usleep(500000); // 500ms polite delay
}
```

**Verify:** Method exists, opt-in flag works, 500ms delay enforced.
**Commit:** `feat(linkedin): add deep-fetch method for full job descriptions`

---

### P-02: Unit Test
**Status:** Depends on P-01
**File:** `tests/Scrapers/LinkedInScraperDeepFetchTest.php` (NEW)
- Mock Guzzle client returning a known HTML fixture containing the description selector
- Assert: correct description text extracted
- Assert: graceful fallback on GuzzleException (returns string or throws — per Q1)
- Assert: `usleep` called between requests (spy or timing check)

**Verify:** `composer test` passes with 0 failures.
**Commit:** `test(linkedin): add unit test for deep-fetch method`

---

### P-03: Config Documentation
**Status:** Depends on P-01
**File:** `config/php-jobspy.yaml` (comment update only)
- Document `deep_fetch: true` as opt-in flag with a note on rate limiting risk

**Commit:** `docs(config): document deep_fetch opt-in flag`

---

## Token Cost Estimate

| Task | Files | Claude Sonnet 4.5 | GPT-4o | Gemini 1.5 Pro | Aider + Ollama (local) |
|---|---|---|---|---|---|
| P-01 deep-fetch method | 1 PHP | ~2,000 tok / ~$0.03 | ~2,200 tok / ~$0.03 | ~2,000 tok / ~$0.01 | ~3,000 tok / $0 |
| P-02 unit test | 1 PHP | ~2,500 tok / ~$0.04 | ~2,800 tok / ~$0.04 | ~2,500 tok / ~$0.02 | ~3,500 tok / $0 |
| P-03 config docs | 1 YAML | ~300 tok / ~$0.00 | ~300 tok / ~$0.00 | ~300 tok / ~$0.00 | ~400 tok / $0 |
| **Total** | **3 files** | **~4,800 / ~$0.07** | **~5,300 / ~$0.07** | **~4,800 / ~$0.03** | **~6,900 / $0** |

> Rates: Claude Sonnet 4.5 ~$3/M input + $15/M output. GPT-4o ~$5/M input + $15/M output. Gemini 1.5 Pro ~$3.5/M input + $10.5/M output.

---

## Commit Policy
- No commit without explicit "proceed" from Alex
- `composer test` must pass before every commit
- One commit per task
