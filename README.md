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
└── scripts/
    ├── fetch_jobs.py          # Aggregates raw listings into local CSV
    └── screen_with_llama.py   # Processes data using local Llama inference
Getting Started
Prerequisites
Python 3.10+

A locally running Llama instance (via Ollama or similar local inference engine)

Setup & Execution
Clone the repository and install dependencies:

Bash
   pip install python-jobspy pandas requests
Run the ingestion layer to harvest fresh postings:

Bash
   python3 scripts/fetch_jobs.py
Run the local AI screening layer to filter high-intent targets:

Bash
   python3 scripts/screen_with_llama.py
