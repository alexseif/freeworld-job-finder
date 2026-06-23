# TODO — php-jobspy
> Spec: SPEC.md | Plan: tasks/plan.md
> This file covers ONLY php-jobspy tasks.

---

## Blocked — Answer Required Before Building

- [ ] **Q1:** Deep-fetch failure mode — Path A (silent fallback string) or Path B (throw DeepFetchException)?

---

## Pending Q1

### P-01: Deep-Fetch Method
- [ ] Add `fetchJobDescription(string $url): string` to `LinkedInScraper.php`
- [ ] Add `deep_fetch` opt-in flag to `scrape()`
- [ ] Add `usleep(500000)` polite delay per request
- [ ] **Await "proceed"** → Commit: `feat(linkedin): add deep-fetch method for full job descriptions`

### P-02: Unit Test
- [ ] Create `tests/Scrapers/LinkedInScraperDeepFetchTest.php`
- [ ] Mock Guzzle client with HTML fixture
- [ ] Assert description extracted correctly
- [ ] Assert fallback behaviour (per Q1)
- [ ] Verify: `composer test` passes
- [ ] **Await "proceed"** → Commit: `test(linkedin): add unit test for deep-fetch method`

### P-03: Config Documentation
- [ ] Add `deep_fetch` comment to `config/php-jobspy.yaml`
- [ ] **Await "proceed"** → Commit: `docs(config): document deep_fetch opt-in flag`
