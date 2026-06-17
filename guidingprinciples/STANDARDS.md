# Guiding Principles & Standards

This document outlines the coding standards, conventions, and ethical scraping guidelines for this project.

## 1. Coding Standards

### PHP Standards (PSR, Composer, & Symfony)
As the project and candidate profile focuses heavily on PHP architecture, any PHP code written must adhere to PHP-FIG's **PSR (PHP Standard Recommendation)** as well as **Composer** and **Symfony** ecosystem conventions:
- **PSR-12**: Extended Coding Style Guide (replacing PSR-2). Enforces rules around indentation (4 spaces), braces, namespaces, and visibility declarations.
- **PSR-4**: Autoloader specification for mapping namespaces to file paths.
- **Composer Standards**: Dependency management must be handled strictly through `composer.json`. All libraries/packages must expose clear autoloading and isolate dependencies.
- **Symfony Standards**: 
  - Leverage standard Symfony component architecture and conventions to ensure enterprise-level robustness.
  - Structure executable scripts conventionally (e.g., placing binaries in a `bin/` directory and domain logic in `src/` following PSR-4).

## 2. Ethical Web Scraping & Job Application Standards

When operating bots or automated scripts to scrape job boards and apply to jobs, strict rules must be followed to avoid bans, maintain good reputation, and adhere to ethical standards.

### Data Ingestion (Scraping)
1. **Respect `robots.txt`**: Always check if the platform disallows automated scraping for specific routes. Obey crawl delays.
2. **Rate Limiting**: Introduce realistic delays (e.g., `time.sleep()`) between requests to avoid overwhelming the target servers and emulate human interaction speed.
3. **Identification**: Use a clear `User-Agent` string (e.g., `MyJobFinderBot/1.0 (contact: your-email@example.com)`). Transparency is preferred over spoofing.
4. **Targeting Public Data**: Only scrape publicly available listings. Do not attempt to bypass authentications, firewalls, or CAPTCHAs via malicious means.
5. **Caching**: Store raw scraped data locally (e.g., in `.csv` files) before processing. This prevents re-scraping the same page multiple times during debugging.

### Automated Applications (Future Scope)
1. **Precision Over Volume**: Only apply to roles that are highly relevant (screened by our local LLM). Spray-and-pray tactics burden recruiters and platform infrastructure.
2. **Platform Terms of Service (ToS)**: Many job platforms strictly prohibit automated applications. Use official APIs (if available) rather than browser automation for applying, or have the AI prepare the application drafts for a human to review and submit with one click.
3. **No Deception**: Do not use AI to generate fabricated experiences or deceive recruiters. AI should only be used to highlight actual, factual experiences that align with the job description.

### Future Integration Notes
- For Phase 3 (Database Persistence), use standard Doctrine ORM or raw PDO with prepared statements.
- Avoid tight coupling. Data flow linearly: Ingestion -> Processing -> Persistence.

## Configuration Standards
- Use **YAML** for robust, human-readable configuration, adhering to Symfony/Laravel standard practices. 
- Configurations should reside in the `config/` directory (e.g., `config/php-jobspy.yaml`).

## Roadblocks & Error Catching
When scraping job boards at scale, anticipate the following roadblocks and adhere to these graceful error-handling principles:
1. **AuthWalls & IP Blocks:** Job boards aggressively block automated traffic. 
    * *Handling:* Scrapers must catch HTTP errors (like 429/999) gracefully and return an empty array rather than throwing a fatal exception. Future iterations should implement proxy rotation or headless browser simulation (Panther/Selenium).
2. **DOM Volatility:** CSS classes and XPath selectors change without warning.
    * *Handling:* Use fuzzy matching (`contains()`), multiple fallback XPaths, and suppress HTML5 parsing warnings. If an element cannot be found, default to `'Unknown'` rather than breaking the entity.
3. **Network Timeouts:** Requests can hang.
    * *Handling:* Always enforce strict HTTP client timeouts (e.g., 15 seconds via Guzzle) to prevent the pipeline from hanging indefinitely.
