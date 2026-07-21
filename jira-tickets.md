# Jira Tickets — LawLens Morocco

---

## Epic 1: Initialisation du Projet

| Ticket | Titre | Description |
|--------|-------|-------------|
| LAW-1 | Configurer Docker & Docker Compose | Créer Dockerfile, docker-compose.yml (Laravel, MySQL, Queue) |
| LAW-2 | Mettre en place GitHub Actions CI | .github/workflows/ci.yml : tests Pest, Pint, migrations |
| LAW-3 | Configurer l'environnement Laravel | .env, Sanctum, base de données, APP_DEBUG |

## Epic 2: Authentification & Rôles

| Ticket | Titre | Description |
|--------|-------|-------------|
| LAW-4 | Implémenter l'inscription publique | POST /api/register — rôle "entrepreneur" par défaut |
| LAW-5 | Implémenter la connexion / déconnexion | POST /api/login, POST /api/logout |
| LAW-6 | Créer le middleware Admin | Vérifier rôle admin sur les routes protégées |
| LAW-7 | Créer la seed du compte Admin | Admin unique créé via seeder sécurisé |
| LAW-8 | Implémenter GET /api/me | Retourner l'utilisateur connecté |

## Epic 3: Gestion des Projets (Entrepreneur)

| Ticket | Titre | Description |
|--------|-------|-------------|
| LAW-9 | Créer le modèle Project et migration | Nom, activité, description, ville, budget, associés, type, statut |
| LAW-10 | Implémenter CRUD Projects API | GET/POST/PUT/DELETE /api/projects — isolation par utilisateur |
| LAW-11 | Créer le formulaire multi-étapes (Blade) | 6 étapes : Infos → Activité → Localisation → Budget → Associés → Confirmation |
| LAW-12 | Créer le Dashboard Entrepreneur | Afficher projets, roadmaps, progression, historique |

## Epic 4: Administration (Back Office)

| Ticket | Titre | Description |
|--------|-------|-------------|
| LAW-13 | Créer le modèle LegalStructure et CRUD Admin | GET/POST/PUT/DELETE /api/admin/legal-structures |
| LAW-14 | Créer le modèle LegalRule et CRUD Admin | GET/POST/PUT/DELETE /api/admin/legal-rules (règles juridiques, fiscales, démarches, documents) |
| LAW-15 | Créer l'Admin Dashboard | Statistiques : utilisateurs, projets, roadmaps, activités, villes |
| LAW-16 | Gérer les utilisateurs (Admin) | Consultation, statut, activité |

## Epic 5: Intelligence Artificielle

| Ticket | Titre | Description |
|--------|-------|-------------|
| LAW-17 | Créer le Service IA | Service qui prépare le contexte (projet + base connaissances) et appelle l'IA |
| LAW-18 | Créer le Job GenerateRoadmap | Dispatché à la création du projet, exécuté en queue |
| LAW-19 | Implémenter le Structured Output | Résumé, forme juridique, étapes, documents, obligations, références, avertissements |
| LAW-20 | Créer la route POST /api/projects/{id}/generate-roadmap | Déclencher la génération, retourner 202 Accepted |

## Epic 6: Roadmap & Suivi

| Ticket | Titre | Description |
|--------|-------|-------------|
| LAW-21 | Créer le modèle Roadmap et migration | Lier au projet, stocker le résultat IA |
| LAW-22 | Créer le modèle RoadmapStep et migration | Étapes avec statuts pending / in_progress / completed |
| LAW-23 | Implémenter le suivi de progression | Mettre à jour les statuts des étapes |

## Epic 7: Tests

| Ticket | Titre | Description |
|--------|-------|-------------|
| LAW-24 | Tests Auth (Pest) | Inscription, connexion, déconnexion, rôles |
| LAW-25 | Tests Projets (Pest) | CRUD, isolation entre utilisateurs, validation |
| LAW-26 | Tests Admin (Pest) | Permissions CRUD legal-structures / legal-rules |
| LAW-27 | Tests IA (Pest) | Job, génération roadmap (IA simulée), 202 Accepted |
| LAW-28 | Tests API Responses (Pest) | Codes HTTP, structure JSON |

## Epic 8: Documentation & Déploiement

| Ticket | Titre | Description |
|--------|-------|-------------|
| LAW-29 | Documenter l'API (README) | Routes, payloads, exemples |
| LAW-30 | Créer le MCD / MLD | Modèle Conceptuel et Logique de Données |
| LAW-31 | Déployer l'application en production | URL publique, APP_DEBUG=false |

## Epic 9: Présentation & Soutenance

| Ticket | Titre | Description |
|--------|-------|-------------|
| LAW-32 | Créer le support de soutenance (slides) | Diapositives couvrant : contexte, objectifs, architecture technique, démonstration, roadmap |
| LAW-33 | Rédiger le script de présentation | Discours structuré pour la soutenance (5-10 min) |
| LAW-34 | Préparer la démonstration en direct | Scénario de démo : création projet → génération roadmap → suivi |
| LAW-35 | Créer le diagramme d'architecture technique | Schéma de l'infrastructure (Docker, Laravel, MySQL, Queue, IA) |
