import json
import pandas as pd
import requests

LOCAL_LLAMA_URL = "http://localhost:11434/api/generate"  # Standard Ollama port
df = pd.read_csv("raw_netherlands_jobs.csv")


def evaluate_job(description):
    # Craft a rigid, binary system prompt to keep the local model focused
    prompt = f"""
    You are a strict technical recruiter vetting candidates.
    Candidate profile: 20+ years experience, expert in PHP, Symfony, and backend MySQL database design.
    
    Job Description:
    {description}
    
    Task: Does this job explicitly require senior-level PHP or backend architecture? 
    Respond with exactly one word: "MATCH" or "BYPASS". Do not write an explanation.
    """

    payload = {"model": "llama3", "prompt": prompt, "stream": False}

    try:
        response = requests.post(LOCAL_LLAMA_URL, json=payload)
        result = response.json()
        return result.get("response", "").strip()
    except Exception:
        return "ERROR"


# Run the evaluation sequentially over your scraped listings
print("Screening jobs with local Llama instance...")
df["Llama_Verdict"] = df["description"].apply(evaluate_job)

# Save your filtered target list
df.to_csv("screened_jobs.csv", index=False)
print("Screening complete. Review 'screened_jobs.csv'.")