<p align="center">
  <strong>LawLens Morocco</strong>
</p>

<p align="center">
  API d'accompagnement juridique intelligent pour les entrepreneurs au Maroc
</p>

<p align="center">
  <a href="#-probl%C3%A8me">Problème</a> ·
  <a href="#-solution">Solution</a> ·
  <a href="#architecture">Architecture</a> ·
  <a href="#-installation">Installation</a> ·
  <a href="#-api">API</a> ·
  <a href="#-docker">Docker</a> ·
  <a href="#-tests">Tests</a> ·
  <a href="#-d%C3%A9ploiement">Déploiement</a>
</p>

---

## Projet

**LawLens Morocco** est une plateforme API (Laravel) qui aide les entrepreneurs et
les professionnels du droit au Maroc à naviguer dans le cadre légal marocain :
formes juridiques, règles applicables et obligations fiscales, jusqu'à la
génération automatique de **feuilles de route de conformité** grâce à l'IA.

## Problème

Créer et faire croître une entreprise au Maroc expose les fondateurs à une
réglementation complexe et dispersée :

- choix des formes juridiques et de leurs règles (SARL, SAS, SA, coopératives…),
- obligations fiscales et sociales selon l'activité,
- rédaction d'un plan de mise en conformité chronologique.

Chaque parcours est spécifique, les sources sont multiples, et il est difficile
d'obtenir une réponse fiable, à jour et personnalisée.

## Solution

LawLens Morocco fournit une **API centrée sur les données**, complété par une
interface web de démonstration :

1. **Catalogue juridique** — formes juridiques, règles, documents et obligations
   fiscales (consultables par le public, administrables par les admins).
2. **Gestion de projets** — les utilisateurs créent leurs projets et suivent leur
   conformité (CRUD complet + authentification par jetons Sanctum).
3. **Feuille de route IA** — génération en arrière-plan (`Queue`) d'une feuille de
   route ordonnée (étapes, documents, obligations fiscales) à partir du contexte
   du projet et de la forme juridique recommandée, avec suivi de progression
   (`pending → in_progress → completed`).
4. **Rôles & permissions** — `entrepreneur` et `admin`, autorisations vérifiées, et
   interfaces web réservées (tableau de bord, roadmaps).

## Architecture

- **Backend** — Laravel 13.x (PHP 8.3), structure API-first.
- **Base de données** — MySQL (local & Docker) ; tests sur SQLite en mémoire.
- **Authentification** — Laravel Sanctum (`auth:sanctum`), rôles et policies.
- **IA** — fournisseur Grok (xAI, `AiService` + HTTP direct), modèle
  `grok-2-latest` via `config/services.php`, exécuté dans une file d'attente
  (`GenerateRoadmap`).
- **File d'attente** — driver `database`.
- **Front web** — Blade + Alpine.js + Tailwind (style design de l'interface).
- **Infra** — Docker Compose (app + queue worker + MySQL + nginx), CI GitHub Actions.

## Installation

### Prérequis

- PHP >= 8.3 (extensions `pdo_mysql`, `mbstring`, `bcmath`, `xml`, `curl`, `zip`, `intl`)
- Composer 2.x
- MySQL 8+ (ou XAMPP) ou Docker
- Node.js 20+ (uniquement pour les assets front)

### Sans Docker

```bash
git clone https://github.com/Mimi-elmo/lawlens-morocco.git
cd lawlensmorocco
composer install
cp .env.example .env
php artisan key:generate
```

Configurez la base de données dans `.env` (MariaDB/MySQL), puis :

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

> Un script d'installation rapide est disponible : `composer run setup`.
> Pour la génération IA, complétez la variable suivante dans `.env` :

```dotenv
GROK_API_KEY=your-key
GROK_BASE_URL=https://api.x.ai/v1
```

### Variables d'environnement clés

| Variable | Description | Exemple |
| --- | --- | --- |
| `DB_CONNECTION` / `DB_DATABASE` | Connexion MySQL | `mysql` / `lawlens_morocco` |
| `QUEUE_CONNECTION` | File d'attente | `database` |
| `SESSION_DRIVER` | Stockage session | `database` |
| `GROK_API_KEY` | Clé API du fournisseur IA (xAI) | — |
| `GROK_BASE_URL` | URL de l'API | `https://api.x.ai/v1` |

### Lancer le worker de queue (nécessaire pour l'IA)

```bash
php artisan queue:work
```

## API

L'API REST est préfixée par `/api`. La documentation Scribe est disponible à
`/docs` (générée par `php artisan scribe:generate`).

### Résumé des routes

| Méthode | URI | Accès | Description |
| --- | --- | --- | --- |
| `POST` | `/api/register` | — | Inscription |
| `POST` | `/api/login` | — | Connexion (jeton) |
| `POST` | `/api/logout` | Auth | Déconnexion |
| `GET` | `/api/me` | Auth | Profil connecté |
| `GET` | `/api/dashboard` | Auth | Statistiques entrepreneur |
| `GET` | `/api/legal-structures` | — | Liste des formes juridiques |
| `GET` | `/api/legal-structures/{id}` | — | Détail d'une forme juridique |
| `GET` | `/api/legal-rules` | — | Liste des règles |
| `GET` | `/api/legal-rules/{id}` | — | Détail d'une règle |
| `GET/POST` | `/api/projects` | Auth | Liste / création de projets |
| `GET/PUT/DELETE` | `/api/projects/{project}` | Auth | Détail / MAJ / suppression |
| `GET` | `/api/projects/{project}/roadmaps` | Auth | Feuilles de route d'un projet |
| `POST` | `/api/projects/{project}/roadmaps` | Auth | Générer une feuille de route (IA, async) |
| `GET` | `/api/roadmaps/{roadmap}` | Auth | Feuille de route détaillée |
| `PUT` | `/api/roadmap-steps/{step}` | Auth | Changer le statut d'une étape |
| `GET` | `/api/admin/dashboard` | Admin | Statistiques globales |
| `GET/POST/PUT/DELETE` | `/api/admin/legal-rules` | Admin | CRUD règles |
| `POST/PUT/DELETE` | `/api/admin/legal-structures` | Admin | MAJ formes juridiques |

### Authentification

L'API est protégée par **jetons Sanctum** (`Auth: Bearer`). Récupérez un jeton via
`POST /api/register` ou `POST /api/login`, puis envoyez-le dans l'en-tête
`Authorization: Bearer <token>`. Sans jeton (ou avec un jeton invalide), les
routes protégées répondent `401 {"message":"Unauthenticated."}`.

#### Exemple : créer un compte puis lister ses projets

**cURL**

```bash
# 1. Inscription → retourne { "user": {...}, "token": "1|..." }
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"Yasmine","email":"yasmine@example.com","password":"secret-123","password_confirmation":"secret-123"}'

# 2. Connexion (si déjà inscrit)
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"yasmine@example.com","password":"secret-123"}'

# 3. Lister mes projets avec le jeton renvoyé
curl http://localhost:8000/api/projects \
  -H "Accept: application/json" \
  -H "Authorization: Bearer 1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
```

**PowerShell (Windows)**

```powershell
$login = Invoke-RestMethod -Method Post -Uri "http://localhost:8000/api/login" `
  -ContentType "application/json" -Body '{"email":"yasmine@example.com","password":"secret-123"}'

$token = $login.token
Invoke-RestMethod -Uri "http://localhost:8000/api/projects" `
  -Headers @{ Authorization = "Bearer $token"; Accept = "application/json" }
```

**Postman**

1. `POST http://localhost:8000/api/login` avec le même corps JSON.
2. Copier `token` depuis la réponse.
3. Sur la requête `GET /api/projects`, onglet *Authorization* → type **Bearer Token** →
   coller le jeton.

Pour les appels web soumis aux cookies, préfixez la session via
`GET /sanctum/csrf-cookie` (non requis en mode jeton pur).

## Docker

```bash
docker compose up -d --build
```

Services :

| Service | Image | Rôle |
| --- | --- | --- |
| `app` | personnalisée (php:8.3-fpm, 3 étapes) | Application Laravel |
| `queue-worker` | personnalisée | Consomme les jobs IA |
| `mysql` | `mysql:8.4` | Base de données |
| `nginx` | `nginx:stable-alpine` | Reverse proxy HTTP |

Vérifier la santé : `curl http://localhost` (réponse `up` sur `/up`).

## Tests

Framework **Pest** (sur SQLite en mémoire) :

```bash
php artisan test
# ou
./vendor/bin/pest
```

- 87 tests, ~196 assertions : authentification, rôles, CRUD légal, projets,
  dashboard, roadmaps (génération, récupération, suivi d'étapes), pages web.
- Qualité : `vendor/bin/pint --test` (style), contrôlé en CI.

## Déploiement

- **CI** — `.github/workflows/ci.yml` : tests + pint sur chaque push `master` /
  `feature/**` et PR vers `master` (PHP 8.3, MySQL 8.4, Composer cache).
- **Image** — `Dockerfile` multi-étapes (node → vendor → php-fpm), optimisée production.
- **Stack cible** — conteneurs définis dans `docker-compose.yml` (app + worker + db + proxy).

## Conventions

- Branches : `feature/…`, `fix/…`, `docs/…` — fusions via Pull Requests vers `master`.
- Style : PHP CS Fixer via Pint, config incluse au dépôt.

## License

Projet interne. (voir dépôt privé).