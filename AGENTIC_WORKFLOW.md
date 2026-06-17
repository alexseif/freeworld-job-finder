# Agentic Coding Workflow (Aider + Ollama)

This project uses [Aider](https://aider.chat/), an industry-standard CLI coding agent, to autonomously implement roadmap features directly into the codebase. 

We currently enforce a **0-cost local execution model** using Ollama, but this architecture is perfectly scalable and can be instantly switched to Anthropic (Claude 3.5 Sonnet) or OpenAI via simple environment variables.

## 1. Installation
Install Aider globally on your machine:
```bash
# Using python/pip (Recommended)
python -m pip install aider-chat

# Or using Homebrew (macOS/Linux)
brew install aider
```

## 2. Recommended Local Models
While standard `llama3` (which you are currently downloading) is excellent for text classification and job screening, autonomous coding requires a model specifically trained on strict code-diff formatting. 

If you find that `llama3` struggles to format files correctly in Aider, we highly recommend pulling a dedicated, lightweight coding model later:
```bash
ollama run qwen2.5-coder:7b
# or
ollama run deepseek-coder-v2
```

## 3. Starting the Autonomous Agent
To launch Aider and bind it to your local Ollama instance at zero cost, run this from the root of your project:

```bash
OLLAMA_API_BASE=http://localhost:11434 aider --model ollama_chat/llama3
```
*(If you downloaded a different model, simply swap `llama3` with `qwen2.5-coder:7b`)*

## 4. Fulfilling Roadmap Tasks
Once inside the Aider chat prompt, you can point it directly to our parity tracker to execute tasks autonomously. 

**Example Workflow:**
1. **Add Context:** Give Aider the files it needs to read and modify.
   `> /add php-jobspy/PYTHON_JOBSPY_PARITY.md php-jobspy/src/Jobspy.php`
2. **Issue the Command:**
   `> "Read the Parity tracker and implement the Glassdoor scraper as detailed. Ensure it matches the LinkedIn scraper architecture and update the tracker when done."`
3. **Execution:** Aider will analyze the code, propose diffs, write the PHP files, and automatically `git commit` the changes to your local repository.

## Scaling to Cloud Providers (Anthropic/OpenAI)
When you are ready to tackle highly complex architectural changes and want to utilize a state-of-the-art model like Claude 3.5 Sonnet, simply swap your execution command in the terminal:

```bash
export ANTHROPIC_API_KEY=your_key_here
aider --model claude-3-5-sonnet-20241022
```
