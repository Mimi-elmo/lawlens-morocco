# LawLens Morocco

## Intelligent Legal and Business Launch Assistant for Morocco

> **Project Type:** Individual Backend + AI Project
> **Project Owner:** Mariam
> **Project Role:** Administrator
> **Technology:** Laravel API + MySQL + AI + Jobs/Queues
> **Project Name:** LawLens Morocco

---

# 1. Project Overview

LawLens Morocco is an intelligent web application designed to help entrepreneurs understand and organize the main legal, administrative and fiscal steps required to launch a business in Morocco.

The entrepreneur describes a business project through a structured form.

The application analyzes:

* The project information;
* The business activity;
* The location;
* The available budget;
* The number of partners;
* The legal structures;
* The legal rules;
* The administrative steps;
* The tax obligations.

The AI then generates a personalized roadmap to help the entrepreneur understand the recommended steps for launching the activity.

The application is an information and orientation tool.

It does not replace:

* A lawyer;
* An accountant;
* A legal consultant;
* An official administration.

---

# 2. Problematic

An entrepreneur who wants to start a business may have difficulties understanding:

* Which legal structure is appropriate;
* Which administrative steps are necessary;
* Which documents are required;
* Which tax obligations apply;
* Which legal rules concern the activity.

Information is often distributed across several sources and can be difficult to understand.

## Main Problem

> How can a Moroccan entrepreneur understand and organize the main steps required to launch a business through a Laravel application combining a structured legal database and artificial intelligence?

---

# 3. Project Objectives

## 3.1 General Objective

Develop an intelligent web application that helps Moroccan entrepreneurs obtain a personalized roadmap for launching their business.

## 3.2 Specific Objectives

The application must allow users to:

* Consult public legal information;
* Consult legal structures;
* Create an entrepreneur account;
* Create a business project;
* Describe a project through a structured form;
* Generate a personalized roadmap using AI;
* Save generated roadmaps;
* Track roadmap progress;
* Consult project history.

The Administrator must be able to:

* Manage users;
* Manage legal structures;
* Manage legal rules;
* Manage administrative information;
* Manage tax information;
* View global statistics.

The technical project must also:

* Expose a REST API;
* Use Laravel Sanctum;
* Use AI structured output;
* Use Jobs and Queues;
* Use Pest tests;
* Use Docker;
* Use GitHub Actions;
* Be documented;
* Be deployable online.

---

# 4. Actors and Permissions

## 4.1 Administrator

The project has one main Administrator: the project owner.

The Administrator is represented by the following role:

```text
role = admin
```

The Administrator has exclusive access to the Admin Dashboard.

The Administrator can:

* Manage users;
* Manage legal structures;
* Create legal structures;
* Update legal structures;
* Delete legal structures;
* Manage legal rules;
* Create legal rules;
* Update legal rules;
* Delete legal rules;
* Manage administrative information;
* Manage fiscal information;
* View statistics.

### Important Rule

The Administrator is not a separate database entity.

The Administrator is a user with:

```text
role = admin
```

There must be no public admin registration.

A normal user must never be able to select:

```text
role = admin
```

during registration.

---

## 4.2 Entrepreneur

An entrepreneur is a normal registered user.

The entrepreneur can:

* Register;
* Login;
* Logout;
* Create projects;
* View own projects;
* Update own projects;
* Delete own projects;
* Generate roadmaps;
* View generated roadmaps;
* Track roadmap steps;
* View project history.

An entrepreneur cannot:

* Access the Admin Dashboard;
* Manage legal structures;
* Manage legal rules;
* View another user's projects;
* Modify global legal information.

---

## 4.3 Visitor

A visitor can:

* View the homepage;
* View public legal information;
* View legal structures;
* View public legal rules;
* Register;
* Login.

---

# 5. Main Functionalities

## 5.1 Authentication

The system must provide:

```text
POST /api/register
POST /api/login
POST /api/logout
GET  /api/me
```

Authentication must use:

```text
Laravel Sanctum
```

The password must always be hashed.

The API must never return the password.

---

# 5.2 User Dashboard

The User Dashboard is dedicated to entrepreneurs.

It must display:

* Number of projects;
* Number of generated roadmaps;
* Roadmap progress;
* Recent projects;
* Recent roadmaps;
* Project history.

The entrepreneur only sees their own data.

---

# 5.3 Admin Dashboard

The Admin Dashboard is dedicated exclusively to the Administrator.

It must display:

* Total users;
* Total entrepreneurs;
* Total projects;
* Total roadmaps;
* Total legal structures;
* Total legal rules;
* Recent activity.

The Admin Dashboard must provide access to:

```text
Users
Legal Structures
Legal Rules
Statistics
```

---

# 5.4 Legal Structures

A legal structure represents a possible legal form for a business.

Examples may include:

* Auto-entrepreneur;
* SARL;
* SARL AU;
* SA;
* Other relevant Moroccan structures.

The Administrator manages legal structures.

Each legal structure may contain:

* Name;
* Slug;
* Description;
* Capital information;
* Tax information;
* Requirements;
* Status.

API:

```text
GET    /api/legal-structures
GET    /api/legal-structures/{id}
POST   /api/admin/legal-structures
PUT    /api/admin/legal-structures/{id}
DELETE /api/admin/legal-structures/{id}
```

---

# 5.5 Legal Rules

Legal rules contain legal, administrative and fiscal information.

Each rule may contain:

* Title;
* Description;
* Category;
* Source;
* Effective date;
* Status.

Possible categories:

```text
legal
administrative
fiscal
document
```

Only the Administrator can create, update or delete legal rules.

---

# 5.6 Project Management

An entrepreneur can create a project.

A project may contain:

```text
Project Name
Business Activity
Description
City
Budget
Number of Partners
Activity Type
Status
```

API:

```text
GET    /api/projects
POST   /api/projects
GET    /api/projects/{id}
PUT    /api/projects/{id}
DELETE /api/projects/{id}
```

Every project belongs to exactly one user.

A user can own multiple projects.

---

# 5.7 Multi-Step Project Form

The project form should be divided into multiple steps.

## Step 1 — General Information

```text
Project Name
Description
```

## Step 2 — Business Activity

```text
Activity
Activity Type
```

## Step 3 — Location

```text
City
```

## Step 4 — Budget

```text
Available Budget
```

## Step 5 — Partners

```text
Number of Partners
```

## Step 6 — Confirmation

The user reviews the information and confirms the project.

---

# 5.8 AI Roadmap Generation

The AI analyzes the project and relevant legal knowledge.

The context must include:

```text
Project Information
Business Activity
Location
Budget
Number of Partners
Relevant Legal Structures
Relevant Legal Rules
Administrative Steps
Tax Obligations
```

The AI must generate structured data.

Example:

```json
{
  "summary": "Business project analysis",
  "recommended_legal_structure": {
    "name": "SARL AU",
    "reason": "..."
  },
  "steps": [
    {
      "title": "Choose the legal structure",
      "description": "...",
      "order": 1
    }
  ],
  "required_documents": [
    {
      "name": "...",
      "required": true
    }
  ],
  "tax_obligations": [
    {
      "name": "...",
      "frequency": "annual"
    }
  ],
  "legal_references": [
    {
      "title": "...",
      "source": "..."
    }
  ],
  "warnings": [
    "Information must be verified with official sources."
  ]
}
```

The AI response must be validated before being stored.

---

# 5.9 Structured Output

The AI output must respect a defined structure.

The output must contain:

```text
summary
recommended legal structure
steps
required documents
tax obligations
legal references
warnings
```

Invalid AI output must not be directly stored.

---

# 5.10 Jobs and Queues

AI generation must be asynchronous.

Flow:

```text
HTTP Request
    ↓
Validation
    ↓
Project Verification
    ↓
Dispatch Job
    ↓
202 Accepted
    ↓
Queue
    ↓
Worker
    ↓
AI Request
    ↓
Structured Output Validation
    ↓
Roadmap Persistence
```

Endpoint:

```text
POST /api/projects/{project}/generate-roadmap
```

Expected response:

```http
202 Accepted
```

---

# 5.11 Roadmap Tracking

Each roadmap contains multiple steps.

A step may have:

```text
pending
in_progress
completed
```

The entrepreneur can update the progress of their roadmap.

The system calculates:

```text
completed_steps / total_steps * 100
```

---

# 6. API Structure

## Authentication

```text
POST /api/register
POST /api/login
POST /api/logout
GET  /api/me
```

## Public Legal Data

```text
GET /api/legal-structures
GET /api/legal-structures/{id}
GET /api/legal-rules
GET /api/legal-rules/{id}
```

## User Projects

```text
GET    /api/projects
POST   /api/projects
GET    /api/projects/{id}
PUT    /api/projects/{id}
DELETE /api/projects/{id}
```

## AI

```text
POST /api/projects/{project}/generate-roadmap
GET  /api/projects/{project}/roadmaps
GET  /api/roadmaps/{roadmap}
```

## Admin

```text
GET    /api/admin/dashboard
GET    /api/admin/users

POST   /api/admin/legal-structures
PUT    /api/admin/legal-structures/{id}
DELETE /api/admin/legal-structures/{id}

POST   /api/admin/legal-rules
PUT    /api/admin/legal-rules/{id}
DELETE /api/admin/legal-rules/{id}
```

---

# 7. Technology Stack

## Backend

```text
PHP
Laravel
Laravel Sanctum
Laravel AI SDK
Jobs
Queues
```

## Database

```text
MySQL
```

## Frontend

```text
Blade
HTML5
CSS3
JavaScript
```

Optional:

```text
Vue.js
React
```

## Testing

```text
Pest
```

## DevOps

```text
Docker
Docker Compose
GitHub Actions
Cloud Deployment
```

---

# 8. Security Requirements

The application must:

* Hash passwords;
* Protect private routes;
* Use authentication middleware;
* Use role-based authorization;
* Use policies;
* Verify project ownership;
* Validate all requests;
* Never expose passwords;
* Never expose API keys;
* Never commit `.env`;
* Use `APP_DEBUG=false` in production.

---

# 9. Testing

Pest tests must cover:

* Registration;
* Login;
* Logout;
* Authentication;
* Authorization;
* Admin access;
* User access;
* Project CRUD;
* Project ownership;
* Legal structure CRUD;
* Legal rule CRUD;
* AI Job dispatch;
* AI response structure;
* API response format.

External AI calls must be mocked in tests.

---

# 10. Docker

The project must contain:

```text
Dockerfile
docker-compose.yml
```

Main services:

```text
app
mysql
queue-worker
```

The environment must be reproducible.

---

# 11. CI/CD

The workflow must be located at:

```text
.github/workflows/ci.yml
```

The workflow must:

1. Install dependencies;
2. Configure the environment;
3. Prepare the test database;
4. Run migrations;
5. Run Pest tests;
6. Run code quality checks.

Optional:

```text
Laravel Pint
```

---

# 12. Documentation

The project must contain:

```text
README.md
```

The README must explain:

* Project problematic;
* Project solution;
* Features;
* Technology stack;
* Installation;
* Local development;
* Docker;
* Tests;
* API;
* Deployment.

API documentation can use:

```text
Scribe
Swagger
OpenAPI
```

---

# 13. Project Limits

LawLens Morocco does not:

* Create companies automatically;
* Submit official documents;
* Access government databases directly;
* Provide professional legal advice;
* Replace a lawyer;
* Replace an accountant;
* Process online payments;
* Generate official signable documents.

The application is an information and orientation tool.

Legal information must be verified through official sources.

---

# 14. Definition of Done

A feature is considered complete only if:

* The code is implemented;
* Validation exists;
* Authorization exists where necessary;
* Tests are written;
* Tests pass;
* Code is reviewed;
* A commit is created;
* The branch is pushed;
* The result is reported.

The feature must not be merged into `main` without explicit confirmation.

