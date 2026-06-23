# SPEC.md — Freeworld Job Finder (Orchestrator)

> **Version:** 3.0 (Career Modeler & LangGraph-style FSM)
> **Purpose:** Defines the orchestration layer that coordinates user career modeling, job ingestion, and AI evaluation pipelines.

---

## 1. Objective
Build a robust, token-efficient Job Discovery and Assessment Platform for freelancers and high-industry tech professionals. The platform operates on two primary engines:
1. **The Career Modeler**: A convenient Resume Builder that allows techies to outline their career roles, employment, contracts, and personal projects. A Skill Set Extractor then uses AI to distill this into a structured, unified skill profile.
2. **The Assessment Graph**: A LangGraph-inspired Finite State Machine (FSM). The user requests a target Job Title and Location. The Graph triggers the decoupled `php-jobspy` library to scrape jobs, and then runs a "fail-fast" pipeline to cut LLM token costs. Jobs that pass the initial filters are deeply evaluated against the user's Skill Profile to determine if they are Qualified, Overqualified, Underqualified, or a Mismatch.

---

## 2. Core Architecture

### 2.1 The Career Modeler
- **ResumeBuilder**: Accepts a PDF upload or an online profile URL. It is less strict than LinkedIn—users only provide what they have (career roles, employment, contracts, personal projects). Outputs a `ResumeDTO`.
- **SkillExtractor**: Sends the parsed `ResumeDTO` to the LLM to extract a clean, normalized list of competencies, outputting a `SkillSetDTO`.
- **Manual Override**: The Web UI presents the extracted `SkillSetDTO` to the user, allowing them to manually alter, add, or remove skills before initiating any job assessments.

### 2.2 The Assessment Graph (State Machine)
- **State (`ScreeningStateDTO`)**: The memory object passed between nodes. Contains the user's `SkillSetDTO`, the target title/location, and arrays of jobs categorized by their current status (`unscreened`, `title_passed`, `evaluated`).
- **Nodes (Action Blocks)**:
  1. **ScrapeNode**: Calls `php-jobspy` based on user's target title/location to populate `$state->unscreened`.
  2. **FastFilterNode**: Pure PHP string matching (0 tokens). Drops jobs containing dealbreaker keywords.
  3. **TitleScreenerNode**: Cheap LLM evaluation (~100 tokens). Approves/rejects based solely on the `title` and `company`.
  4. **DeepFetchNode**: Calls `php-jobspy` to fetch full HTML descriptions for the surviving jobs.
  5. **DeepEvaluatorNode**: Expensive LLM evaluation (~2000 tokens). Compares the full description against the `SkillSetDTO` and assigns an assessment classification (Qualified, Overqualified, Underqualified).
- **Edges**: Conditional logic deciding the next node based on the State.

### 2.3 The Web Portal (UI Interface)
To adhere to the latest industry practices and strict separation of concerns, the platform will utilize a decoupled architecture (API-First Design):
- **Core Engine (Backend)**: The PHP domain (LangGraph FSM, Modeler, and `php-jobspy`) operates purely as an API server. It exposes REST or GraphQL endpoints.
- **Web Portal (Frontend)**: A modern JavaScript framework (e.g., Next.js or Vite) that handles the user experience. It will feature premium, dynamic aesthetics with Vanilla CSS (glassmorphism, micro-animations) to ensure the UI feels responsive and state-of-the-art.

---

## 3. Project Structure

```text
freeworld-job-finder/
├── backend/                     # The PHP Core Domain (API & FSM)
│   ├── bin/                     # CLI fallback tools
│   ├── config/                  # Orchestrator configurations
│   ├── php-jobspy/              # (Sub-package) The dumb data source
│   ├── public/                  # API entrypoint (index.php)
│   └── src/
│       ├── Api/                 # HTTP Controllers / Endpoints
│       ├── Career/              # ResumeBuilder (PDF/URL parser) & SkillExtractor
│       ├── DTO/                 # State and Data Transfer Objects
│       ├── Graph/               # State Machine Engine
│       ├── Nodes/               # FSM Action Blocks
│       └── LLM/                 # LlamaClient
└── frontend/                    # The Web Portal (Next.js or Vite)
    ├── src/
    │   ├── components/          # Reusable UI elements
    │   ├── pages/               # Routing (Dashboard, Resume Builder, Job Results)
    │   └── styles/              # Vanilla CSS (premium, dynamic designs)
```

---

## 4. Tech Stack & Standards
- **Backend**: PHP 8.1+ with a lightweight HTTP router/framework (e.g., Slim or Symfony) serving as a pure API.
- **Frontend**: Next.js or Vite (React/JS) leveraging Vanilla CSS for a premium, dynamic, and highly aesthetic UI.
- **Resume Parsing**: `smalot/pdfparser` for PDF extraction, Symfony `dom-crawler` for URL profile parsing.
- **Coding Standard**: PER-CS (Backend).
- **Type Safety**: Heavy reliance on DTOs.
- **Network**: `symfony/http-client` for calling local Ollama or remote LLM APIs.

---

## 5. Boundaries & Separation of Concerns
### Always
- Keep LLM and Graph logic strictly inside the `freeworld-job-finder` namespaces.
- Separate the "Career Definition" (Resume/Skills) from the "Job Evaluation" (Graph). The Graph just consumes the `SkillSetDTO`.
- Fail jobs as early in the pipeline as possible to save tokens.

### Never
- Never leak Graph logic or AI inference calls into the `php-jobspy` directory.
- Never send raw HTML descriptions to the LLM (always clean it in the node).

---

## 6. Testing Strategy
- Unit tests for the `ScreeningGraph` using mock Nodes.
- Mock the LLM client to return static evaluations and extracted skills.
- Ensure the state transitions properly along edges based on mock boolean/enum returns.
