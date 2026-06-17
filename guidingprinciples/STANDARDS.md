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
