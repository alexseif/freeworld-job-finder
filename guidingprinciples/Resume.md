# Resume & ATS Standards

## Strict International Resume Standards

Our compilation utility generates tailored resumes calibrated to specific geopolitical standards:

*   **UK Format**: Focused on clear demarcations between Contract and Permanent roles.
*   **EU Format**: Adheres strictly to GDPR compliance layouts, aggressively masking liability variables (e.g., age, marital status, photo) to ensure unbiased screening.
*   **US Format**: Highly condensed, 1-page dense metrics formats prioritizing quantifiable outcomes and high-impact action verbs.

## AI-Driven Contextual Extraction

The generation process relies on strict deterministic retrieval:

*   The local Llama model must dynamically query the relational SQLite database (`me.db`) via localized SQL criteria.
*   The objective is to extract **only** contextually matching technical milestones and project-specific pain points that align with the target vacancy.
*   **Absolute Rule**: The extraction process must *never* alter historical facts or hallucinate capabilities.

## Beating Applicant Tracking Systems (ATS)

To bypass automated screening engines, all generated markdown must adhere to the following strict rules:

1.  **Raw Text Layout Priority**: The structure must be parsable as a linear, flat text stream.
2.  **Semantic Keyword Mirroring**: Exact technical terms identified in the vacancy must be mirrored directly from verified historical entries.
3.  **Zero Decorative Graphics**: No charts, progress bars, or icons that disrupt OCR/parsing algorithms.
4.  **Zero Multi-Column Layouts**: Tables and complex column structures are strictly prohibited.
5.  **Strict Reverse-Chronological Ordering**: Experience and education must always flow from the most recent to the oldest.
