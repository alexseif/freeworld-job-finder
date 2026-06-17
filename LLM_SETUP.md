# Local LLM Setup Guide

The `freeworld-job-finder` pipeline utilizes a local Large Language Model (LLM) to intelligently screen, evaluate, and filter the raw job data ingested by `php-jobspy`.

By running the model locally, you ensure **100% data privacy**, zero API costs, and complete control over the classification logic.

## 1. Install Ollama
We use [Ollama](https://ollama.com/) as the local inference engine. It provides a highly optimized REST API right on your local machine.

* **Linux / macOS:**
  ```bash
  curl -fsSL https://ollama.com/install.sh | sh
  ```
* **Windows:** Download the standard installer from the official website.

## 2. Pull the Screening Model
We recommend using the standard `llama3` model for rapid, highly-accurate text classification.

Open your terminal and run:
```bash
ollama run llama3
```
*Note: This will download the model weights (approx. 4.7GB). Once the download finishes and drops you into a chat prompt, simply type `/bye` to exit. The Ollama service will remain actively running in the background.*

## 3. Verify the API
The `OllamaAdapter` engine expects the Ollama API to be listening locally. Verify the connection by running a quick ping in your terminal:
```bash
curl http://localhost:11434/api/generate -d '{
  "model": "llama3",
  "prompt": "Say hello world",
  "stream": false
}'
```

## 4. Execute the AI Screening Pipeline
Once the `php-jobspy` ingestion layer has generated the raw data (`./bin/fetch_jobs`), you can pass that dataset to your local LLM for evaluation.

Run the screening script:
```bash
./bin/screen_jobs
```

### What happens under the hood?
1. The script parses your `raw_netherlands_jobs.csv`.
2. It feeds each job title and description into the local Llama3 instance with a strict system prompt.
3. The LLM determines if the job aligns with your predefined technical capabilities.
4. The system automatically outputs the validated, high-value opportunities to `screened_jobs.csv`.
