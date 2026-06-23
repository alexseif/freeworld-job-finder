# Stop Paying AI to Read Garbage Job Posts (And Help Us Build the Antidote)

Let’s be honest: hunting for a tech job right now feels like screaming into a void that occasionally auto-replies with "Unfortunately, we are moving forward with other candidates."

Naturally, as engineers, our first instinct is to automate the screaming. We build scrapers. We hook them up to GPT-4. We send it 500 job descriptions a day and say, *"Hey AI, tell me if I'm qualified for this Senior PHP role."* 

And then the OpenAI bill arrives. Congratulations, you are now unemployed *and* broke. 

Sending entire HTML job descriptions to an LLM to evaluate is the equivalent of buying a Ferrari just to drive to the end of your driveway to check the mail. It's expensive, overkill, and frankly, a little embarrassing. 

Enter **Freeworld Job Finder**.

### The "Fail-Fast" LangGraph Engine
We are building a dual-engine, decoupled platform designed specifically to aggressively protect your API tokens while actually finding you jobs you qualify for. 

Instead of a brute-force approach, we engineered a LangGraph-inspired Finite State Machine (FSM) in PHP. It acts as an elite, ruthless bouncer for your tokens:
1. **The Career Modeler**: Give us whatever messy PDF resume or random URL profile you have. We don't care. Our Skill Extractor uses a local LLM to cleanly distill it into a normalized `SkillSetDTO`. No LinkedIn-style forced form fields. Just raw data.
2. **The Assessor Graph**: You tell us what you want ("Principal Engineer, Remote"). Our standalone scraper library (`php-jobspy`) grabs the initial list. 
3. **The Gauntlet**: Jobs are immediately passed through a "Fail-Fast" pipeline. If a job has a dealbreaker keyword (e.g., "Clearance Required"), it dies at Node 1 (0 tokens). If the title is "Junior Dev", it dies at Node 2 (~100 tokens). 

Only the absolute highest-quality, most promising jobs survive to reach the "Deep Evaluator" Node, where we finally spend the tokens to deeply compare the job description against your extracted skill set. 

You find out if you are Qualified, Overqualified, or a Mismatch, and you didn't bankrupt yourself doing it.

### We Need Contributors!
We are currently building this out with a decoupled architecture (a pure PHP/Symfony Backend API and a beautiful, glassmorphic Next.js/Vite Web Portal). 

If you are tired of the job-hunting grind and want to help build a ruthless, efficient, open-source pipeline that automates the nonsense, we want you. We need React/Vue wizards for the frontend, and PHP engineers who appreciate strict DTOs and pure domain logic.

Come help us automate the void. [GitHub Link Here]

---

## 🐦 Twitter / X Thread

**Tweet 1:**
Applying for jobs is broken. Building an AI to apply for jobs for you? Extremely expensive. 
If you send 100 job descriptions to GPT-4 to see if you qualify, OpenAI gets rich and you stay unemployed. 📉 
We're fixing this. Meet Freeworld Job Finder. 🧵👇

**Tweet 2:**
Sending massive HTML payloads to an LLM is a rookie mistake. We built a LangGraph-style Finite State Machine in PHP. 
It acts as a ruthless bouncer. Jobs have to survive 3 layers of cheap filters before they are allowed to touch your expensive API tokens. 🛡️

**Tweet 3:**
Engine 1: Give us your messy PDF resume. Our Career Modeler distills it into a normalized Skill Set. No strict LinkedIn forms.
Engine 2: The Assessor Graph scrapes jobs and mercilessly drops the garbage ones early. It only deep-evaluates the absolute best matches. 🎯

**Tweet 4:**
We are building this open-source with a decoupled API backend and a premium React/Vite web portal. 
If you’re a PHP engineer or Frontend wizard tired of the job market nonsense, come help us automate the void. Contributors welcome! 🤝💻 [GitHub Link]
