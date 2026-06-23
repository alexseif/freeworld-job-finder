# TODO — Freeworld Job Finder (Orchestrator)
> Spec: SPEC.md | Plan: tasks/plan.md

---

## Blocked
- [ ] **Dependency:** Await completion of `php-jobspy` foundation tasks (P-01 through P-04).

---

## Pending Execution

### O-01: Backend API Foundation
- [ ] `git checkout -b feat/o01-api-foundation`
- [ ] Restructure project (`mkdir backend/src`, move existing core files).
- [ ] Initialize lightweight HTTP framework (Slim or Symfony Skeleton).
- [ ] Create basic routing and health check endpoints.
- [ ] Commit: `feat: initialize backend API architecture`

### O-02: LLM Inference Client
- [ ] `git checkout -b feat/o02-llm-client`
- [ ] Create `backend/src/LLM/LlamaClient.php`.
- [ ] Write Unit Tests (`MockHttpClient`).
- [ ] Code comments & PER-CS formatting.
- [ ] Commit: `feat: implement LLM inference client via Symfony HttpClient`

### O-03: Career Modeler (PDF/URL & Skills)
- [ ] `git checkout -b feat/o03-career-modeler`
- [ ] `composer require smalot/pdfparser` in the backend.
- [ ] Create `ResumeBuilder` and `SkillExtractor`.
- [ ] Create `POST /api/resume/extract` endpoint returning JSON.
- [ ] Commit: `feat: implement career modeler and API endpoint for skill extraction`

### O-04: The Graph Engine & Nodes
- [ ] `git checkout -b feat/o04-graph-engine`
- [ ] Implement `ScreeningState` and `ScreeningGraph` (FSM logic).
- [ ] Implement assessment nodes (`TitleScreener`, `DeepEvaluator`).
- [ ] Create `POST /api/jobs/assess` endpoint to start the graph.
- [ ] Commit: `feat: implement LangGraph state machine and assessment API`

### O-05: Web Portal (Frontend UI)
- [ ] `git checkout -b feat/o05-frontend-ui`
- [ ] Run `npx create-vite@latest frontend --template react-ts` (or similar)
- [ ] Implement global Vanilla CSS for premium aesthetic (animations, glassmorphism).
- [ ] Build Resume Upload & Skill Editor components.
- [ ] Build Assessment Dashboard component communicating with the backend APIs.
- [ ] Commit: `feat: initialize dynamic web portal UI`
