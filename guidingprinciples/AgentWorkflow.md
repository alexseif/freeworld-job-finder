# Agentic Orchestration Framework

This document outlines the strict multi-phase, multi-agent workflow for executing tasks within this repository. All AI agents interacting with this codebase must adhere to this exact 5-tier configuration.

---

## 0. Phase Zero: Training & Token Optimization Mode
To prevent massive token bloat and ensure the agents genuinely learn your specific coding preferences, the system strictly begins in **Training Mode**.
1. **Conversational First**: For the first several tasks, the system will not run autonomously. It will execute micro-steps and converse with you for manual correction.
2. **Experience Learning**: After every correction, the agent will dynamically update its own profile (e.g., `agents/Planner.md`) and the project context to reflect what it learned from you.
3. **Context Compression**: Loading every architectural markdown file on every loop burns tokens. Once a workflow is perfected conversationally, the system will compress the context into highly optimized, token-efficient "Skills."
4. **Graduation**: Only after a few successful, conversational runs will we crystallize these workflows into final, permanent AI "Skills".

---

## 1. Global Rules
- **Specificity Mandatory**: Every feature, task, and prompt must be hyper-specific. 
- **Ambiguity Protocol**: If any requirement or instruction is ambiguous, the agent must immediately **STOP** execution and provide the user with **2 distinct options**, detailing the specific trade-off value for each.
- **Licensing & Ethics**: All outputs must adhere to the CC BY-NC 4.0 License and strict ethical guidelines.

---

## 2. Project Rules (`freeworld-job-finder`)
Agents must strictly ingest and adhere to the repository's established documentation. Do not hallucinate new standards.
- **See `STANDARDS.md`**: Enforces PHP 8.2+, Symfony Components, SQLite 3NF, PSR-4/12, and strict typing.
- **See `Architecture.md`**: Defines the local-first, decoupled system philosophy and deterministic data execution flow.
- **See `ResumeBuilder.md`**: Enforces strict Data Transfer Object (DTO) separation of concerns for the final output compiler.

---

## 3. Index Codebase
Before planning or implementing any feature, the agent must index and analyze the current state of the repository. This guarantees that new features integrate flawlessly without duplicating existing abstractions or breaking current dependencies.

---

## 4. Planning Phase (Agent Persona: The Planner)
When a feature request or GitHub issue is received, a dedicated **Planner Agent** must process it:
- **Detailed Planning**: The Planner must generate a comprehensive, highly detailed technical specification.
- **Cost Estimation**: The plan MUST include an estimated table cost (tokens/compute time) based on the specific LLM being utilized.
- **Approval Gate**: Planning requires explicit User Approval before moving to the implementation pipeline.
- **Structural Requirements**: The plan must explicitly define:
    1. The target Design Patterns.
    2. The exact System Workflow.
    3. Strict Feature Isolation and boundaries.
- **Task Decomposition**: Every high-level feature must be broken down into multiple granular, actionable tasks. No monolithic executions are permitted.

---

## 5. Implementation Pipeline
Execution is handled by specialized AI agent personas in a sequential, isolated pipeline. For every single granular task, the system must generate specific skills and prompts to instantiate the following sequence:

### 5a. Agent Persona: The Coder
- **Role**: Write the codebase for a single granular task.
- **Skillset**: Focused purely on robust implementation, leveraging deep knowledge of PHP, SQLite, and the immediate task context. 

### 5b. Agent Persona: The Reviewer
- **Role**: Conduct a rigorous, antagonistic code review of the Coder's output.
- **Skillset**: Security analysis, PSR-12 enforcement, architectural compliance checking against the Global/Project Rules, and logic flaw detection.

### 5c. Agent Persona: The Tester
- **Role**: Validate the code mechanically.
- **Skillset**: Generate and execute test scripts, run dry-runs (e.g., syntax linting `php -l`), and verify database schema creations without executing destructive actions.

### 5d. Reporting & Documentation
- Once testing passes, the system must generate a final **Outcome Report**.
- Document the build process, update any internal documentation with new changes, and present the report to the user.
- **PAUSE**: Explicitly wait and allow for User Feedback.

### 5e. Sign-Off & Iteration
- Upon user approval ("OK"), finalize the task.
- Reset the agent context and prepare to move on to the next task or feature in the Planner's queue.

---

## 6. Version Control & Git Operations (Industry Standard)
The system strictly enforces **Trunk-Based Development** or **Feature Branching** coupled with **Conventional Commits**. Git operations must follow this sequence:
1. **Branching**: Before the Coder begins, a feature branch must be created (e.g., `git checkout -b feat/issue-1-sqlite-schema`).
2. **Atomic Commits**: Commits must be atomic, representing a single logical change. 
3. **Commit Naming**: Must use Conventional Commits (e.g., `feat:`, `fix:`, `chore:`, `refactor:`, `docs:`). The commit message must include the Issue number (e.g., `feat: implement 3NF schema (Resolves #1)`).
4. **Commit Timing**: The agent is **prohibited** from committing code until the **Tester** and **Reviewer** have explicitly passed the mechanical and architectural audits.
5. **Publishing**: Once the Reviewer passes and the user signs off, the agent merges or opens a PR, pushes to the remote, and closes the assigned issue.
