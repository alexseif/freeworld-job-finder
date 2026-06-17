# Project Roadmap: Freeworld Job Finder

This roadmap outlines the transition from our initial Python proof-of-concept to a robust, PSR-compliant PHP architecture, expanding into a full suite of job-hunting automation tools.

## Phase 1: PHP Project Conversion (Current)
- [x] Convert existing `fetch_jobs` and `screen_with_llama` scripts from Python to PHP.
- [x] Establish PSR-12 and PSR-4 coding standards as the foundation.
- [x] Implement basic PHP file I/O and standard cURL requests for the local Llama inference engine.

## Phase 2: Ingestion Package Development
- [ ] **Identify or Create `php-jobspy` Alternative**: Research existing PHP scraping libraries (e.g., Goutte, Panther) or build a custom package that mimics `python-jobspy`'s ability to cleanly aggregate listings from LinkedIn and Indeed without overhead.
- [ ] Implement rate limiting, user-agent rotation, and robust error handling as defined in our ethical scraping standards.

## Phase 3: Future Capabilities Architecture
- [ ] **1. Resume Builder**: Develop a module that structures your professional experience, technical skills, and achievements into targeted, dynamic resumes based on specific job contexts.
- [ ] **2. Advanced Job Scraper**: Integrate the Phase 2 package with a relational database (e.g., MySQL) to maintain state, prevent duplicate processing, and track job market trends over time.
- [ ] **3. Job Applier (Auto/Semi-Auto)**: Build an application module that maps your dynamic resume to scraped, screened jobs. It will prepare application drafts or utilize official APIs to submit applications, strictly adhering to platform ToS and our ethical guidelines (no deceptive AI generation).
