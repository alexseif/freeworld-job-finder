# Optimized Codebase Index

*This document serves as the ultra-compressed structural context for all agents, eliminating the need to mass-scan directories.*

## 1. Product Repository (`freeworld-job-finder`)
**Namespace:** `FreeworldJobFinder\`
**Root Directory:** `/`

*   `src/Database/`
    *   *(Empty)* - Pending Issue #1 (SQLite 3NF Initialization).
*   `src/Fetcher/`
    *   `JobFetcher.php`: Scrapes raw jobs.
*   `src/Screener/`
    *   `JobScreener.php`: Legacy AI orchestration for screening jobs.
    *   `Adapters/`: Legacy LLM adapter interfaces.
*   `database/` (Pending)
    *   Target location for local-first `me.db` SQLite storage.

## 2. Factory Repository (`freeworld-job-finder/orchestrator`)
**Namespace:** `FreeworldOrchestrator\`
**Root Directory:** `/orchestrator/`

*   `composer.json`: Enforces `neuron-core/neuron-ai` (^3.15).
*   `PLAN.md`: The active specification for building the Native PHP Orchestrator.
*   `guidingprinciples/`: Symmetrical clone of product governance rules.
*   `src/Agents/` *(Pending)*: Target location for Neuron Agent classes.
*   `bin/orchestrator` *(Pending)*: Target location for Workflow execution script.
