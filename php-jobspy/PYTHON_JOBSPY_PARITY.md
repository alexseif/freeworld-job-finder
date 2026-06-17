# Python JobSpy Parity Tracker

This document tracks our progress in achieving feature parity with the original Python [`JobSpy`](https://github.com/speedyapply/JobSpy).

## 📊 Core Architecture
- [ ] **Asynchronous/Concurrent Execution:** Implement concurrent HTTP requests (via Guzzle Promises or ReactPHP) to scrape multiple pages or boards simultaneously.
- [ ] **Proxy Rotation:** Build a robust proxy manager to accept a list of proxies and rotate them on every request to bypass Cloudflare/LinkedIn AuthWalls.
- [ ] **Pagination Handling:** Add automatic offset tracking to loop through search pages until the exact `results_wanted` threshold is met.
- [ ] **Deep Description Fetching:** Create secondary scraper logic to automatically visit the underlying job URL and fetch the full, rich-text job description (currently we only extract the SERP card data).

## 🌐 Job Board Implementations
- [x] **LinkedIn** (Public SERP implemented)
- [ ] **Indeed** (High Priority: Usually requires Cloudflare bypass, TLS fingerprinting, or reverse-engineering their mobile API endpoints)
- [ ] **Glassdoor**
- [ ] **ZipRecruiter**

## 🔍 Advanced Search Filters
- [ ] **Job Type:** Filter by Full-time, Part-time, Contract, Internship.
- [ ] **Remote Status:** Filter explicitly by Onsite, Hybrid, or Remote.
- [ ] **Search Radius:** Add radius limits (miles/kilometers) relative to the provided location.
- [ ] **Salary Formatting:** Standardize and extract minimum/maximum salary boundaries when provided on the card.
- [ ] **Easy Apply Only:** Filter to only return jobs that have the "Easy Apply" integration.

## 💾 Output Formats
- [x] CSV Export
- [ ] JSON Export
- [ ] SQLite / MySQL direct database insertion support.
