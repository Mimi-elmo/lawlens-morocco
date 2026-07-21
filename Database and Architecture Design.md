# LawLens Morocco

# Database and Architecture Design

---

# 1. Database Design Rules

The database must be designed according to the project domain.

The system separates:

```text
ADMINISTRATOR-MANAGED LEGAL DATA
```

from:

```text
ENTREPRENEUR-OWNED PROJECT DATA
```

The Administrator manages the legal knowledge base.

The entrepreneur uses this knowledge base to generate a personalized roadmap.

---

# 2. MCD — Modèle Conceptuel de Données

The MCD must follow MERISE rules.

## MCD Rules

The MCD contains:

* Entities;
* Attributes;
* Identifiers;
* Associations;
* Cardinalities.

The MCD must not contain:

* Foreign keys;
* Database-specific implementation details;
* SQL types;
* Pivot tables created only for implementation.

---

# 3. MCD Entities

## UTILISATEUR

Attributes:

```text
ID utilisateur
nom
email
mot_de_passe
role
statut
date_creation
```

The role can be:

```text
admin
entrepreneur
```

Important:

```text
ADMIN is not a separate entity.
```

The Administrator is a user with:

```text
role = admin
```

---

## PROJET

Attributes:

```text
ID projet
nom
activite
description
ville
budget
nombre_associes
type_activite
statut
date_creation
```

---

## ROADMAP

Attributes:

```text
ID roadmap
resume
reponse_IA
statut
progression
date_generation
```

---

## FORME_JURIDIQUE

Attributes:

```text
ID forme
nom
slug
description
capital_information
tax_information
statut
```

---

## REGLE_JURIDIQUE

Attributes:

```text
ID regle
titre
description
categorie
source
date_entree_vigueur
statut
```

Categories:

```text
legal
administrative
fiscal
document
```

---

## ETAPE

Attributes:

```text
ID etape
titre
description
ordre
statut
```

---

## DOCUMENT

Attributes:

```text
ID document
nom
description
obligatoire
statut
```

---

## OBLIGATION_FISCALE

Attributes:

```text
ID obligation
nom
description
frequence
obligatoire
```

---

# 4. MCD Associations

## UTILISATEUR — CRÉER — PROJET

```text
UTILISATEUR (0,N)
        |
      CRÉER
        |
PROJET (1,1)
```

Meaning:

* A user can create zero or many projects;
* A project belongs to exactly one user.

---

## PROJET — GÉNÉRER — ROADMAP

```text
PROJET (0,N)
        |
     GÉNÉRER
        |
ROADMAP (1,1)
```

Meaning:

* A project can generate multiple roadmaps;
* Each roadmap belongs to one project.

---

## ROADMAP — RECOMMANDER — FORME_JURIDIQUE

```text
ROADMAP (0,N)
          |
      RECOMMANDER
          |
FORME_JURIDIQUE (0,1)
```

Meaning:

* A roadmap may recommend a legal structure;
* A legal structure may be recommended in multiple roadmaps.

---

## FORME_JURIDIQUE — CONCERNER — REGLE_JURIDIQUE

```text
FORME_JURIDIQUE (0,N)
          |
       CONCERNER
          |
REGLE_JURIDIQUE (0,N)
```

This is an N:N relationship.

In the MLD, it becomes:

```text
FORME_REGLE
```

---

## ROADMAP — CONTENIR — ETAPE

```text
ROADMAP (1,1)
        |
     CONTENIR
        |
ETAPE (1,N)
```

A roadmap contains one or more steps.

---

## ROADMAP — REQUÉRIR — DOCUMENT

```text
ROADMAP (1,1)
        |
     REQUÉRIR
        |
DOCUMENT (0,N)
```

A roadmap may require multiple documents.

---

## ROADMAP — COMPORTER — OBLIGATION_FISCALE

```text
ROADMAP (1,1)
        |
     COMPORTER
        |
OBLIGATION_FISCALE (0,N)
```

A roadmap may contain multiple tax obligations.

---

# 5. MLD — Modèle Logique de Données

The MLD transforms the MCD into relational tables.

The MLD contains:

* Tables;
* Primary Keys;
* Foreign Keys;
* Constraints;
* Association tables.

---

# 6. MLD Tables

## UTILISATEUR

```text
UTILISATEUR
-----------
id_utilisateur PK
nom
email UNIQUE
mot_de_passe
role
statut
date_creation
```

---

## PROJET

```text
PROJET
------
id_projet PK
id_utilisateur FK
nom
activite
description
ville
budget
nombre_associes
type_activite
statut
date_creation
```

Relationship:

```text
UTILISATEUR 1,N PROJET
```

---

## ROADMAP

```text
ROADMAP
-------
id_roadmap PK
id_projet FK
id_forme_recommandee FK NULL
resume
reponse_IA
statut
progression
date_generation
```

---

## FORME_JURIDIQUE

```text
FORME_JURIDIQUE
---------------
id_forme PK
nom
slug UNIQUE
description
capital_information
tax_information
statut
```

---

## REGLE_JURIDIQUE

```text
REGLE_JURIDIQUE
---------------
id_regle PK
titre
description
categorie
source
date_entree_vigueur
statut
```

---

## FORME_REGLE

This is the association table for the N:N relationship.

```text
FORME_REGLE
-----------
id_forme PK/FK
id_regle PK/FK
```

Composite Primary Key:

```text
(id_forme, id_regle)
```

---

## ETAPE_ROADMAP

```text
ETAPE_ROADMAP
-------------
id_etape PK
id_roadmap FK
titre
description
ordre
statut
```

---

## DOCUMENT_ROADMAP

```text
DOCUMENT_ROADMAP
----------------
id_document PK
id_roadmap FK
nom
description
obligatoire
statut
```

---

## OBLIGATION_FISCALE

```text
OBLIGATION_FISCALE
------------------
id_obligation PK
id_roadmap FK
nom
description
frequence
obligatoire
```

---

# 7. Database Relationships

```text
users
  │
  │ 1,N
  ▼
projects
  │
  │ 1,N
  ▼
roadmaps
  │
  ├── 1,N ── roadmap_steps
  │
  ├── 1,N ── roadmap_documents
  │
  └── 1,N ── tax_obligations
```

Legal knowledge:

```text
legal_structures
        │
        │ N,N
        │
    legal_rules
```

Implemented through:

```text
legal_structure_rule
```

---

# 8. Application Architecture

```text
┌──────────────────────────────┐
│       FRONTEND / BLADE        │
│       HTML / CSS / JS         │
└──────────────┬───────────────┘
               │
               ▼
┌──────────────────────────────┐
│          LARAVEL API          │
│          API ROUTES           │
└──────────────┬───────────────┘
               │
               ▼
┌──────────────────────────────┐
│       MIDDLEWARE              │
│   Auth + Admin + Policies     │
└──────────────┬───────────────┘
               │
               ▼
┌──────────────────────────────┐
│        CONTROLLERS            │
│        FORM REQUESTS          │
│        API RESOURCES          │
└──────────────┬───────────────┘
               │
               ▼
┌──────────────────────────────┐
│          SERVICES             │
│       BUSINESS LOGIC          │
└──────────────┬───────────────┘
               │
       ┌───────┴────────┐
       ▼                ▼
┌──────────────┐  ┌──────────────┐
│   ELOQUENT   │  │     JOBS     │
│   MODELS     │  │   QUEUES     │
└──────┬───────┘  └──────┬───────┘
       │                 │
       ▼                 ▼
┌──────────────┐  ┌──────────────┐
│    MYSQL     │  │   AI API     │
└──────────────┘  └──────────────┘
```

---

# 9. AI Architecture

```text
USER
 │
 ▼
PROJECT
 │
 ▼
CONTEXT BUILDER
 │
 ├── Project Information
 ├── Activity
 ├── Location
 ├── Budget
 ├── Partners
 ├── Legal Structures
 ├── Legal Rules
 └── Tax Information
 │
 ▼
AI JOB
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
ROADMAP
 │
 ├── Steps
 ├── Documents
 ├── Tax Obligations
 └── Legal References
```

---

# 10. Queue Architecture

```text
HTTP REQUEST
     │
     ▼
VALIDATE PROJECT
     │
     ▼
DISPATCH JOB
     │
     ▼
202 ACCEPTED
     │
     ▼
QUEUE
     │
     ▼
WORKER
     │
     ▼
AI REQUEST
     │
     ▼
STRUCTURED OUTPUT
     │
     ▼
DATABASE
```

---

# 11. Recommended Laravel Structure

```text
app/
├── Models/
│   ├── User.php
│   ├── Project.php
│   ├── Roadmap.php
│   ├── RoadmapStep.php
│   ├── RoadmapDocument.php
│   ├── TaxObligation.php
│   ├── LegalStructure.php
│   └── LegalRule.php
│
├── Http/
│   ├── Controllers/
│   ├── Requests/
│   └── Resources/
│
├── Jobs/
│   └── GenerateRoadmapJob.php
│
├── Services/
│   ├── RoadmapService.php
│   └── AIContextBuilder.php
│
├── Policies/
│   ├── ProjectPolicy.php
│   └── RoadmapPolicy.php
│
└── AI/
    └── RoadmapAgent.php
```

---

# 12. Database Rules

The project must:

* Use migrations;
* Use foreign keys;
* Use indexes;
* Use unique constraints;
* Use factories;
* Use seeders;
* Use Eloquent relationships;
* Protect user data.

---

# 13. Security Rules

Never:

* Store passwords in plain text;
* Store API keys in database tables;
* Commit `.env`;
* Allow public admin registration;
* Allow users to access other users' projects.

Always:

* Hash passwords;
* Validate requests;
* Use policies;
* Use authentication middleware;
* Use role authorization.

---

# 14. MCD and MLD Separation

## MCD

```text
Conceptual Model
```

Contains:

```text
Entities
Attributes
Identifiers
Associations
Cardinalities
```

Does not contain:

```text
Foreign Keys
SQL Types
Pivot Tables
```

---

## MLD

```text
Logical Relational Model
```

Contains:

```text
Tables
PK
FK
Association Tables
Constraints
```

The MLD is derived from the MCD.

---

# 15. Draw.io Files

The project must contain two separate diagrams:

```text
LawLens_Morocco_MCD_Merise.drawio
```

and:

```text
LawLens_Morocco_MLD.drawio
```

They must never be mixed.

The MCD represents the conceptual Merise model.

The MLD represents the relational database model.

---

# 16. Final Architecture Principle

The main business flow is:

```text
ADMIN
  │
  ▼
LEGAL KNOWLEDGE BASE
  │
  ▼
DATABASE
  │
  ▼
ENTREPRENEUR
  │
  ▼
PROJECT
  │
  ▼
AI CONTEXT
  │
  ▼
ROADMAP
  │
  ▼
TRACKING
```

The Administrator controls the knowledge base.

The Entrepreneur uses the knowledge base.

The AI combines the project information with the legal knowledge base.

The generated roadmap is stored and tracked.

LawLens Morocco must remain an information and orientation tool and must not be presented as a replacement for official legal or professional advice.
