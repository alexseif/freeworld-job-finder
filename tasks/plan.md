# Plan — Freeworld Job Finder (Orchestrator)
> Spec: SPEC.md | Updated: 2026-06-23

---

## Dependency Graph
```
[php-jobspy] → O-01 Web API Foundation → O-02 LLM Client → O-03 Career Modeler (PDF/URL) → O-04 Graph Engine → O-05 Web Portal (Frontend)
```
*(Note: O-tasks represent Orchestrator tasks. They depend on `php-jobspy` being fully functional to scrape).*

---

## Tasks (Vertical Slices)

### O-01: Backend API Foundation
**Branch:** `feat/o01-api-foundation`
- Restructure project to move PHP domain into `backend/` and initialize HTTP routing (e.g., Slim Framework or Symfony Skeleton).
- Create endpoints for the Web UI to communicate with.
- **Verification:** API responds with 200 OK to health check.

### O-02: LLM Inference Client
**Branch:** `feat/o02-llm-client`
- Create `backend/src/LLM/LlamaClient.php` using `symfony/http-client`.
- Implement a method to ping the local Ollama instance.
- **Verification:** Unit test with `MockHttpClient`.

### O-03: Career Modeler (PDF/URL & Skills)
**Branch:** `feat/o03-career-modeler`
- Implement `ResumeBuilder` utilizing `smalot/pdfparser` for PDFs and `dom-crawler` for online profiles.
- Implement `SkillExtractor` to parse the `ResumeDTO` via LLM into a `SkillSetDTO`.
- Expose an API endpoint `POST /api/resume/extract` that returns the `SkillSetDTO` to the frontend for manual alteration.
- **Verification:** API successfully parses a mock PDF and returns JSON skills.

### O-04: The Graph Engine & Nodes
**Branch:** `feat/o04-graph-engine`
- Implement the `ScreeningState`, `ScreeningGraph`, and the Token-Saving Nodes (`FastFilter`, `TitleScreener`, `DeepFetch`, `DeepEvaluator`).
- Expose `POST /api/jobs/assess` endpoint to start the graph using the user's manually confirmed `SkillSetDTO`.
- **Verification:** Unit tests confirm state mutates correctly across nodes.

### O-05: Web Portal (Frontend UI)
**Branch:** `feat/o05-frontend-ui`
- Initialize `frontend/` using Vite (React/Vue/JS) or Next.js.
- Build a premium, dynamic interface with Vanilla CSS (vibrant colors, glassmorphism, micro-animations).
- Build the "Resume Upload" view.
- Build the "Skill Set Editor" view (where users manually alter extracted skills).
- Build the "Assessment Dashboard" view (displaying Qualified, Underqualified, Mismatch buckets).
- **Verification:** Frontend runs locally and successfully fetches from `backend/api`.

---

## Estimated Token Cost

| Task | Files | Claude Sonnet 4.5 | GPT-4o | Gemini 1.5 Pro | Aider + Ollama |
|---|---|---|---|---|---|
| O-01 LLM Client | 1 PHP | ~1,500 tok / ~$0.02 | ~1,600 tok / ~$0.02 | ~1,500 tok / ~$0.01 | ~2,000 tok |
| O-02 Modeler | 4 PHP | ~3,000 tok / ~$0.04 | ~3,200 tok / ~$0.04 | ~3,000 tok / ~$0.02 | ~4,500 tok |
| O-03 Engine | 2 PHP | ~2,000 tok / ~$0.03 | ~2,200 tok / ~$0.03 | ~2,000 tok / ~$0.01 | ~3,000 tok |
| O-04 Nodes | 3 PHP | ~3,500 tok / ~$0.05 | ~3,800 tok / ~$0.05 | ~3,500 tok / ~$0.02 | ~5,000 tok |
| O-05 CLI | 2 PHP | ~1,500 tok / ~$0.02 | ~1,600 tok / ~$0.02 | ~1,500 tok / ~$0.01 | ~2,000 tok |
| **Total** | **12 files**| **~11,500 / ~$0.16** | **~12,400 / ~$0.16** | **~11,500 / ~$0.07** | **~16,500 tok**|
