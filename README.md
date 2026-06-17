# freeworld-job-finder

A pragmatic, local AI-driven pipeline designed to scrape, aggregate, and evaluate remote and contract job listings. This project serves as a practical testing ground for mastering local Large Language Model (LLM) orchestration and deterministic data processing.

## Project Vision
Finding high-velocity contract opportunities shouldn't require manual scrolling or expensive API dependencies. This project aims to turn job discovery into a clean engineering pipeline by:
1. **Scraping:** Aggregating raw listings across multiple platforms cleanly into structured local data.
2. **Filtering:** Utilizing a locally hosted Llama instance to run binary classification over descriptions.
3. **Evolving:** Serving as a foundational codebase to step-by-step learn agentic loops, state machines, and persistent memory tracking.

## Technical Architecture (Phase 1)
The system currently operates as a simple, linear data-processing pipeline:
* **Ingestion Layer:** Leverages `python-jobspy` to pull raw postings directly from targeted platforms without middle-man web overhead.
* **Inference Layer:** Connects to a local Llama instance via local API endpoints to execute deterministic system prompts and evaluate skill-set alignment.

## Project Structure
```text
freeworld-job-finder/
├── .gitignore
├── README.md
├── ROADMAP.md
├── composer.json
├── bin/
│   ├── fetch_jobs             # Executable to run ingestion layer
│   └── screen_with_llama      # Executable to run inference layer
└── src/
    ├── Fetcher/               # Domain logic for data aggregation
    └── Screener/              # Domain logic for Llama evaluation
Getting Started
Prerequisites
PHP 8.1+

A locally running Llama instance (via Ollama or similar local inference engine)

Setup & Execution
Clone the repository:
(Composer dependencies will be added in Phase 2)

### Search Configuration
Configure your job search parameters in the `config/php-jobspy.yaml` file:
```yaml
php_jobspy:
  site_name: 
    - linkedin
  search_term: 'Senior PHP Developer'
  location: 'Netherlands'
  results_wanted: 20
  hours_old: 72
  country_integrity: 'netherlands'
```
You can modify these parameters at any time without altering the codebase.

Run the ingestion layer to harvest fresh postings:

Bash
   ./bin/fetch_jobs
Run the local AI screening layer to filter high-intent targets:

Bash
   ./bin/screen_with_llama
