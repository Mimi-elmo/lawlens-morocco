# LawLens Morocco

## Project Brief

> **Project Type:** Individual Backend + AI Project
> **Project Owner:** Mariam
> **Project Role:** Administrator
> **Project Name:** LawLens Morocco
> **Target Market:** Morocco
> **Project Goal:** Help entrepreneurs understand and organize the steps required to launch a business in Morocco.

---

# 1. Project Summary

LawLens Morocco is an intelligent web application that helps Moroccan entrepreneurs understand the legal, administrative and fiscal steps required to launch a business.

The entrepreneur describes their business project through a structured form.

The application analyzes the project information and combines it with legal and administrative information stored in the database.

An AI system then generates a personalized roadmap containing:

* Recommended legal structure;
* Administrative steps;
* Required documents;
* Tax obligations;
* Legal references;
* Warnings and recommendations.

The generated roadmap is stored and can be followed by the entrepreneur.

---

# 2. Main Problem

Entrepreneurs often have difficulties understanding:

* Which legal structure to choose;
* Which administrative steps are required;
* Which documents are necessary;
* Which tax obligations apply;
* Which legal information concerns their activity.

Information is often distributed across different sources.

LawLens Morocco centralizes the information and transforms it into a structured and personalized roadmap.

---

# 3. Main Solution

The application follows this flow:

```text
Entrepreneur
      │
      ▼
Creates an account
      │
      ▼
Creates a business project
      │
      ▼
Provides project information
      │
      ├── Activity
      ├── City
      ├── Budget
      └── Number of Partners
      │
      ▼
System retrieves relevant legal information
      │
      ▼
AI analyzes the project
      │
      ▼
Structured Roadmap Generated
      │
      ▼
Entrepreneur follows the steps
```

---

# 4. Actors

## Administrator

The Administrator is the project owner.

The Administrator has exclusive access to the Admin Dashboard.

The Administrator manages:

* Users;
* Legal structures;
* Legal rules;
* Administrative information;
* Fiscal information;
* Statistics.

The Administrator is not a separate database entity.

The Administrator is a user with:

```text
role = admin
```

There is no public Admin registration.

---

## Entrepreneur

The entrepreneur is a normal registered user.

The entrepreneur can:

* Register;
* Login;
* Create projects;
* Manage own projects;
* Generate roadmaps;
* View project history;
* Track roadmap progress.

The entrepreneur cannot:

* Access the Admin Dashboard;
* Manage legal data;
* Access another user's projects.

---

## Visitor

The visitor can:

* View the homepage;
* View public legal structures;
* View public legal information;
* Register;
* Login.

---

# 5. Main Features

## Authentication

```text
Register
Login
Logout
Current User
```

Technology:

```text
Laravel Sanctum
```

---

## User Dashboard

The User Dashboard displays:

* User projects;
* Generated roadmaps;
* Project history;
* Roadmap progress.

The user only sees their own data.

---

## Admin Dashboard

The Admin Dashboard displays:

* Total users;
* Total projects;
* Total roadmaps;
* Total legal structures;
* Total legal rules.

The Administrator can manage the legal knowledge base.

---

## Legal Structures

The Administrator can:

* Create;
* View;
* Update;
* Delete;

legal structures.

Examples:

```text
Auto-entrepreneur
SARL
SARL AU
SA
```

---

## Legal Rules

The Administrator can manage:

```text
Legal rules
Administrative rules
Fiscal rules
Document requirements
```

Each rule contains:

```text
Title
Description
Category
Source
Effective Date
Status
```

---

## Projects

An entrepreneur creates a project containing:

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

---

## AI Roadmap

The AI receives:

```text
Project Information
Activity
City
Budget
Number of Partners
Legal Structures
Legal Rules
Tax Information
```

The AI generates:

```text
Summary
Recommended Legal Structure
Administrative Steps
Required Documents
Tax Obligations
Legal References
Warnings
```

The output must be structured and validated.

---

# 6. AI Workflow

```text
PROJECT CREATED
      │
      ▼
USER REQUESTS ROADMAP
      │
      ▼
PROJECT VALIDATION
      │
      ▼
RELEVANT LEGAL DATA RETRIEVED
      │
      ▼
AI CONTEXT CREATED
      │
      ▼
JOB DISPATCHED
      │
      ▼
QUEUE WORKER
      │
      ▼
AI PROVIDER
      │
      ▼
STRUCTURED OUTPUT
      │
      ▼
VALIDATION
      │
      ▼
ROADMAP SAVED
```

The generation must be asynchronous.

The API can return:

```http
202 Accepted
```

---

# 7. Technical Stack

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

# 8. Main Database Entities

The core database contains:

```text
users
legal_structures
legal_rules
projects
roadmaps
roadmap_steps
roadmap_documents
tax_obligations
```

The relationship between legal structures and legal rules is many-to-many and requires an association table:

```text
legal_structure_rule
```

---

# 9. Main Business Flow

```text
ADMIN
  │
  ▼
MANAGES LEGAL KNOWLEDGE
  │
  ▼
DATABASE
  │
  ▼
ENTREPRENEUR
  │
  ▼
CREATES PROJECT
  │
  ▼
AI ANALYZES PROJECT
  │
  ▼
PERSONALIZED ROADMAP
  │
  ▼
ENTREPRENEUR TRACKS PROGRESS
```

---

# 10. Main API Endpoints

## Authentication

```text
POST /api/register
POST /api/login
POST /api/logout
GET  /api/me
```

## Legal Structures

```text
GET    /api/legal-structures
GET    /api/legal-structures/{id}
POST   /api/admin/legal-structures
PUT    /api/admin/legal-structures/{id}
DELETE /api/admin/legal-structures/{id}
```

## Legal Rules

```text
GET    /api/legal-rules
GET    /api/legal-rules/{id}
POST   /api/admin/legal-rules
PUT    /api/admin/legal-rules/{id}
DELETE /api/admin/legal-rules/{id}
```

## Projects

```text
GET    /api/projects
POST   /api/projects
GET    /api/projects/{id}
PUT    /api/projects/{id}
DELETE /api/projects/{id}
```

## AI Roadmap

```text
POST /api/projects/{project}/generate-roadmap
```

---

# 11. Project Principles

OpenCode must follow these principles:

1. Build the project step by step.
2. Do not implement everything at once.
3. Follow the development plan.
4. Keep Admin and Entrepreneur permissions separate.
5. Protect user data.
6. Use Laravel best practices.
7. Use Form Requests for validation.
8. Use Policies for authorization.
9. Use Services for complex business logic.
10. Use Jobs and Queues for AI generation.
11. Use structured AI output.
12. Write tests for every important feature.
13. Never commit secrets.
14. Never merge automatically into `main`.

---

# 12. Git Workflow

Each feature must use a dedicated branch.

Example:

```text
feature/authentication
feature/projects
feature/legal-structures
feature/legal-rules
feature/ai-roadmap
feature/admin-dashboard
feature/tests
feature/docker
feature/ci-cd
```

Workflow:

```text
Create Branch
      ↓
Implement Feature
      ↓
Write Tests
      ↓
Run Tests
      ↓
Review Code
      ↓
Commit
      ↓
Push
      ↓
STOP
      ↓
Wait for Merge Confirmation
```

OpenCode must never merge automatically into:

```text
main
```

---

# 13. Definition of Done

A feature is complete only when:

```text
Code implemented
Validation added
Authorization verified
Tests written
Tests passing
Code reviewed
Commit created
Branch pushed
```

After that, OpenCode must stop and wait for explicit merge confirmation.

---

# 14. Project Limitations

LawLens Morocco is an information and orientation tool.

It does not:

* Create companies automatically;
* Submit official documents;
* Access government databases directly;
* Replace a lawyer;
* Replace an accountant;
* Provide professional legal advice.

All legal information must be verified with official sources.

---

# 15. OpenCode Instruction

Before starting any implementation:

1. Read `PROJECT_BRIEF.md`.
2. Read `PROJECT_SPECIFICATION.md`.
3. Read `DATABASE_AND_ARCHITECTURE.md`.
4. Read `DEVELOPMENT_PLAN.md`.
5. Inspect the existing repository.
6. Check the current Git branch.
7. Check the current Git status.
8. Identify the next incomplete task.
9. Implement only that task.
10. Test the implementation.
11. Commit the changes.
12. Push the feature branch.
13. Stop and request confirmation before merging into `main`.

The project must be implemented incrementally and safely.

No feature should be skipped.

No automatic merge is allowed.
