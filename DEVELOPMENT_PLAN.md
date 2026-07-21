# LawLens Morocco

# Development Plan

## OpenCode Execution    Rules

---

# 1. General Rule

This project must be implemented step by step.

OpenCode must not implement the entire project in one operation.

Each task must be:

```text
Read
→ Analyze
→ Implement
→ Test
→ Review
→ Commit
→ Push
→ Report
```

Only then can the next task begin.

---

# 2. Important Project Rules

## Rule 1 — Do Not Skip Tasks

Tasks must be executed in order.

Do not jump directly to AI before:

* Database;
* Authentication;
* Authorization;
* Projects;
* Legal data.

---

## Rule 2 — Do Not Modify Unrelated Features

When working on one feature:

```text
feature/authentication
```

Do not modify unrelated features such as:

```text
feature/ai-roadmap
feature/admin-dashboard
```

unless absolutely necessary.

---

## Rule 3 — Check Before Modifying

Before modifying files:

```bash
git status
```

Inspect:

* Current branch;
* Existing changes;
* Existing files;
* Existing migrations;
* Existing tests.

Do not overwrite existing work without understanding it.

---

# 3. Git Workflow

## Main Branch

```text
main
```

The `main` branch must always remain stable.

---

## Feature Branches

Use:

```text
feature/project-setup
feature/database
feature/authentication
feature/authorization
feature/legal-structures
feature/legal-rules
feature/projects
feature/user-dashboard
feature/admin-dashboard
feature/ai-roadmap
feature/queue
feature/roadmap-tracking
feature/tests
feature/docker
feature/ci-cd
feature/documentation
```

---

# 4. Branch Workflow

For every feature:

```bash
git checkout main
git pull origin main

git checkout -b feature/feature-name
```

Implement the feature.

Run tests.

Commit:

```bash
git add .
git commit -m "feat(scope): description"
```

Push:

```bash
git push -u origin feature/feature-name
```

Then stop.

---

# 5. Mandatory Merge Confirmation

OpenCode MUST NOT merge automatically.

After completing a feature, OpenCode must display:

```text
The feature is ready to merge into main.

Branch:
[branch name]

Changes:
[list of changes]

Tests:
[test results]

Commit:
[commit hash]

Push:
[push status]

Please confirm the merge before continuing.
```

OpenCode must stop and wait.

No merge is allowed until explicit confirmation.

---

# 6. Commit Convention

Use Conventional Commits.

Examples:

```text
feat(auth): implement authentication
feat(database): create core database structure
feat(projects): implement project CRUD
feat(ai): implement roadmap generation
test(auth): add authentication tests
test(projects): add project authorization tests
fix(projects): fix ownership validation
chore(docker): add Docker configuration
ci: add GitHub Actions workflow
docs: update API documentation
```

---

# 7. DEVELOPMENT TASKS

---

# PHASE 0 — PROJECT ANALYSIS

## TASK 1 — Analyze Existing Project

### Objectives

* Inspect the repository;
* Inspect `git status`;
* Identify Laravel version;
* Identify existing code;
* Identify existing database;
* Identify existing authentication;
* Identify existing dependencies.

### Commands

```bash
git status
git branch
git log --oneline -5
php artisan --version
```

### Deliverable

A written analysis before code modification.

### Commit

No commit if no code changes.

---

# PHASE 1 — PROJECT SETUP

## TASK 2 — Configure Laravel Project

### Objectives

Configure:

* `.env`;
* `.env.example`;
* MySQL;
* Application key;
* Testing environment.

### Verify

```bash
php artisan about
php artisan migrate:status
```

### Commit

```text
chore(setup): configure Laravel project
```

### Push

Push the branch.

Stop for merge confirmation.

---

# PHASE 2 — DATABASE

## TASK 3 — Implement Database Structure

Implement:

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

### Requirements

* Migrations;
* Foreign keys;
* Indexes;
* Constraints;
* Models;
* Relationships.

### Important

The MCD and MLD must remain separate.

### Commit

```text
feat(database): implement core database structure
```

---

## TASK 4 — Factories and Seeders

Create:

* User factory;
* Legal structure factory;
* Legal rule factory;
* Project factory;
* Roadmap factory.

Create seeders for:

* Admin;
* Legal structures;
* Legal rules.

The Admin must be created through a secure seeder.

### Commit

```text
feat(database): add factories and seeders
```

---

# PHASE 3 — AUTHENTICATION

## TASK 5 — Registration

Implement:

```text
POST /api/register
```

Rules:

* Public users become entrepreneurs;
* The role cannot be selected publicly;
* Password is hashed;
* Validation is required.

### Commit

```text
feat(auth): implement user registration
```

---

## TASK 6 — Login and Logout

Implement:

```text
POST /api/login
POST /api/logout
GET /api/me
```

Use:

```text
Laravel Sanctum
```

### Commit

```text
feat(auth): implement login and logout
```

---

# PHASE 4 — AUTHORIZATION

## TASK 7 — Roles and Middleware

Implement:

```text
admin
entrepreneur
```

Create Admin middleware.

Only Admin can access:

```text
/api/admin/*
```

### Commit

```text
feat(auth): implement role authorization
```

---

## TASK 8 — Policies

Create policies for:

```text
Project
Roadmap
```

A user can only access their own data.

Test:

```text
User A cannot access User B project.
```

### Commit

```text
feat(auth): implement ownership policies
```

---

# PHASE 5 — LEGAL STRUCTURES

## TASK 9 — Public Legal Structures

Implement:

```text
GET /api/legal-structures
GET /api/legal-structures/{id}
```

### Commit

```text
feat(legal-structures): implement public access
```

---

## TASK 10 — Admin Legal Structures CRUD

Implement:

```text
POST
PUT
DELETE
```

Only Admin.

Add:

* Form Requests;
* API Resources;
* Authorization;
* Tests.

### Commit

```text
feat(legal-structures): implement admin CRUD
```

---

# PHASE 6 — LEGAL RULES

## TASK 11 — Public Legal Rules

Implement:

```text
GET /api/legal-rules
GET /api/legal-rules/{id}
```

### Commit

```text
feat(legal-rules): implement public access
```

---

## TASK 12 — Admin Legal Rules CRUD

Implement:

```text
POST
PUT
DELETE
```

Only Admin.

Categories:

```text
legal
administrative
fiscal
document
```

### Commit

```text
feat(legal-rules): implement admin CRUD
```

---

# PHASE 7 — PROJECTS

## TASK 13 — Project Creation

Implement:

```text
POST /api/projects
```

Validate:

* Name;
* Activity;
* Description;
* City;
* Budget;
* Number of partners.

### Commit

```text
feat(projects): implement project creation
```

---

## TASK 14 — Project CRUD

Implement:

```text
GET
POST
PUT
DELETE
```

All operations must verify ownership.

### Commit

```text
feat(projects): implement project CRUD
```

---

# PHASE 8 — USER DASHBOARD

## TASK 15 — User Dashboard

Display:

* User projects;
* Roadmaps;
* Progress;
* History.

The user must never see another user's data.

### Commit

```text
feat(user-dashboard): implement entrepreneur dashboard
```

---

# PHASE 9 — ADMIN DASHBOARD

## TASK 16 — Admin Dashboard

Display:

```text
Total Users
Total Projects
Total Roadmaps
Total Legal Structures
Total Legal Rules
```

Only Admin.

### Commit

```text
feat(admin-dashboard): implement admin statistics
```

---

# PHASE 10 — AI ROADMAP

## TASK 17 — AI Configuration

Configure:

* AI provider;
* API key;
* Laravel AI SDK;
* Structured output.

Never hardcode API keys.

### Commit

```text
feat(ai): configure AI integration
```

---

## TASK 18 — AI Context Builder

Create a service that gathers:

```text
Project
Activity
Location
Budget
Partners
Legal Structures
Legal Rules
Tax Information
```

The service must build a structured context.

### Commit

```text
feat(ai): implement roadmap context builder
```

---

## TASK 19 — Structured AI Output

Implement a structured response containing:

```text
summary
recommended_legal_structure
steps
required_documents
tax_obligations
legal_references
warnings
```

Validate the response.

### Commit

```text
feat(ai): implement structured roadmap output
```

---

# PHASE 11 — JOBS AND QUEUES

## TASK 20 — Generate Roadmap Job

Create:

```text
GenerateRoadmapJob
```

Flow:

```text
Project
→ Job
→ AI
→ Validate
→ Save Roadmap
```

### Commit

```text
feat(queue): implement roadmap generation job
```

---

## TASK 21 — Queue Endpoint

Implement:

```text
POST /api/projects/{project}/generate-roadmap
```

Response:

```http
202 Accepted
```

### Commit

```text
feat(ai): dispatch roadmap generation job
```

---

## TASK 22 — Queue Failure Handling

Implement:

* Retry;
* Failure handling;
* Logging.

### Commit

```text
feat(queue): implement job failure handling
```

---

# PHASE 12 — ROADMAP TRACKING

## TASK 23 — Roadmap Steps

Implement:

```text
pending
in_progress
completed
```

### Commit

```text
feat(roadmap): implement roadmap steps
```

---

## TASK 24 — Progress Calculation

Implement:

```text
completed steps / total steps * 100
```

### Commit

```text
feat(roadmap): implement progress tracking
```

---

# PHASE 13 — TESTING

## TASK 25 — Authentication Tests

Test:

* Register;
* Login;
* Logout;
* Invalid credentials;
* Protected routes.

### Commit

```text
test(auth): add authentication tests
```

---

## TASK 26 — Authorization Tests

Test:

* Entrepreneur cannot access Admin;
* User cannot access another user's project;
* Admin can access Admin features.

### Commit

```text
test(auth): add authorization tests
```

---

## TASK 27 — CRUD Tests

Test:

* Projects;
* Legal structures;
* Legal rules.

### Commit

```text
test(api): add CRUD tests
```

---

## TASK 28 — AI and Queue Tests

Mock external AI services.

Test:

* Job dispatch;
* Job execution;
* Structured output;
* Roadmap persistence.

### Commit

```text
test(ai): add roadmap generation tests
```

---

# PHASE 14 — DOCKER

## TASK 29 — Dockerfile

Create:

```text
Dockerfile
```

Configure Laravel environment.

### Commit

```text
chore(docker): add application Dockerfile
```

---

## TASK 30 — Docker Compose

Create services:

```text
app
mysql
queue-worker
```

### Commit

```text
chore(docker): add Docker Compose services
```

---

# PHASE 15 — CI/CD

## TASK 31 — GitHub Actions

Create:

```text
.github/workflows/ci.yml
```

Pipeline:

```text
Checkout
↓
Install PHP
↓
Install Composer
↓
Configure environment
↓
Prepare database
↓
Run migrations
↓
Run Pest
↓
Run Pint
```

### Commit

```text
ci: add GitHub Actions pipeline
```

---

# PHASE 16 — DOCUMENTATION

## TASK 32 — README

Document:

* Project;
* Problem;
* Solution;
* Installation;
* API;
* Docker;
* Tests;
* Deployment.

### Commit

```text
docs: complete project README
```

---

## TASK 33 — API Documentation

Use:

```text
Scribe
```

or:

```text
OpenAPI
Swagger
```

### Commit

```text
docs(api): add API documentation
```

---

# PHASE 17 — FINAL AUDIT

## TASK 34 — Security Audit

Verify:

* No secrets in Git;
* `.env` ignored;
* Passwords hidden;
* Admin protected;
* Ownership verified;
* Validation active.

---

## TASK 35 — Test Audit

Run:

```bash
php artisan test
```

or:

```bash
./vendor/bin/pest
```

All tests must pass.

---

## TASK 36 — Final Git Audit

Verify:

```bash
git status
git branch
git log --oneline
```

Verify:

* All branches pushed;
* All features tested;
* No uncommitted changes.

---

# FINAL RULE

OpenCode must not merge into `main` automatically.

Before every merge:

```text
STOP
REPORT
WAIT FOR CONFIRMATION
```

Only the project owner can authorize the merge.
