import pandas as pd
from jobspy import scrape_jobs

# Pure deterministic parameters matching your target profile
jobs = scrape_jobs(
    site_name=["linkedin", "indeed"],
    search_term="Senior PHP Developer",
    location="Netherlands",
    results_wanted=20,
    hours_old=72, 
    country_integrity="netherlands"
)

# Output directly to a clean CSV for review
jobs.to_csv("raw_netherlands_jobs.csv", index=False)
print(f"Successfully scraped {len(jobs)} jobs.")