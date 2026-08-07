# Audit final — LawLens Morocco (Phase 17)

Base audité : `master` @ `a1e831f` (Merge PR #26 — `fix/dynamic-links`)

## Task 34 — Sécurité

| Contrôle | Résultat |
| --- | --- |
| Secrets dans le dépôt (clés API, tokens, clés privées, mots de passe) | Aucun trouvé (`composer audit` + scan regex sur le dépôt) |
| `.env` ignoré par git | OK (`.gitignore` ligne 3) ; `.env.example` ne contient que des placeholders vides |
| Hachage des mots de passe | bcrypt (driver par défaut Laravel, `Hash::make` dans `AuthController`) |
| Authentification API | Sanctum (jetons) ; endpoints admin protégés par `AdminMiddleware` (alias `admin`) → 403 pour les non-admins |
| Politiques d'accès | `ProjectPolicy` (view/create/update/delete) et `RoadmapPolicy` (view/create) enregistrées via `Gate::policy` dans `AppServiceProvider` |
| Validation des entrées | FormRequest sur tous les endpoints d'écriture (auth, projets, CRUD admin, étapes de roadmap) |
| Alertes de dépendances | 8 avis (guzzlehttp/guzzle 7.15.1, league/commonmark 2.8.3) corrigés → 7.15.3 / 2.9.0 (PR `fix/security-deps`) ; `composer audit` est désormais vide |

## Task 35 — Tests

- `php artisan test` : **87 tests / 196 assertions — tous verts**
- Couverture : authentification (register/login/logout/me), CRUD projets, feuilles de route (génération, récupération, étapes), catalogue juridique (public + admin), middleware admin, tableaux de bord (entrepreneur + admin), pages web (welcome, auth, projets, roadmaps, admin)
- CI : workflow GitHub Actions déclenché sur push/PR vers `master` et `feature/**`

## Task 36 — Git

- `master` contient l'intégralité des travaux (PR #14 → #26) ; arbre de travail propre
- Branche obsolète supprimée : `feature/ai-generation-ui` (approche Grok remplacée par `AiService` + job `GenerateRoadmap`)
- Branches restantes à fusionner : `docs/api` (documentation Scribe), `fix/security-deps` (dépendances), `docs/audit` (présent rapport)
