# Structure du Projet - DataCenter Pro

## 📂 Arborescence complète

```
datacenter_project/
│
├── 📄 README.md                          # Documentation principale
├── 📄 .env                              # Configuration environnement
├── 📄 composer.json                     # Dépendances PHP
├── 📄 package.json                      # Dépendances npm
├── 📄 phpunit.xml                       # Configuration tests
├── 📄 artisan                           # CLI Laravel
│
├── 📁 app/
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php      # Authentification
│   │   │   │   └── RegisterController.php   # Inscription (avec user_type optionnel)
│   │   │   ├── AdminDashboardController.php # Dashboard Admin (50 lignes)
│   │   │   ├── TechController.php           # Dashboard Responsable Tech
│   │   │   ├── UserDashboardController.php  # Dashboard Utilisateur (contrôle d'accès)
│   │   │   ├── ReservationController.php    # Gestion réservations
│   │   │   ├── IncidentController.php       # Gestion incidents
│   │   │   └── ResourceManagerController.php # Gestion des ressources
│   │   │
│   │   └── 📁 Middleware/
│   │       └── RoleMiddleware.php           # Vérification des rôles (support multi-rôles)
│   │
│   ├── 📁 Models/
│   │   ├── User.php                    # Utilisateur (avec user_type, role_id)
│   │   ├── Role.php                    # Rôle (4 types: Admin, Tech, Interne, Normal)
│   │   ├── Resource.php                # Équipement (50 items)
│   │   ├── ResourceCategory.php        # Catégorie (4 types)
│   │   ├── Reservation.php             # Réservation (statuts: EN ATTENTE, VALIDÉE, REFUSÉE)
│   │   ├── Incident.php                # Incident IT
│   │   ├── MaintenancePeriod.php       # Période de maintenance
│   │   └── Notification.php            # Notification utilisateur
│   │
│   └── 📁 Providers/
│       └── AppServiceProvider.php       # Configuration service
│
├── 📁 database/
│   ├── 📁 migrations/
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_01_12_171557_create_roles_table.php
│   │   ├── 2026_01_12_171559_create_users_table.php
│   │   ├── 2026_01_12_172310_create_resource_categories_table.php
│   │   ├── 2026_01_12_172320_create_resources_table.php
│   │   ├── 2026_01_12_172401_create_reservations_table.php
│   │   ├── 2026_01_13_222820_create_incidents_table.php
│   │   ├── 2026_01_14_014612_create_notifications_table.php
│   │   ├── 2026_01_26_000001_add_tech_manager_to_resources.php
│   │   ├── 2026_01_26_000002_add_rejection_reason_to_reservations.php
│   │   ├── 2026_01_26_000003_enhance_reservations_table.php
│   │   ├── 2026_01_26_000004_create_account_requests_table.php
│   │   ├── 2026_01_26_000005_create_maintenance_periods_table.php
│   │   ├── 2026_01_26_000006_add_missing_columns_to_tables.php
│   │   ├── 2026_01_27_012746_add_user_type_to_users_table.php      # user_type NOT NULL
│   │   ├── 2026_01_27_013821_make_user_type_nullable_in_users_table.php # user_type NULLABLE
│   │   ├── 2026_01_27_022900_add_utilisateur_normal_role.php       # Nouveau rôle
│   │   └── 2026_01_27_023019_update_user_roles.php                 # Assignation rôles
│   │
│   ├── 📁 seeders/
│   │   ├── DatabaseSeeder.php           # Seeder principal
│   │   └── DataCenterSeeder.php          # Données test (4 utilisateurs + 50 équipements)
│   │
│   └── 📁 factories/
│       └── UserFactory.php              # Factory utilisateurs
│
├── 📁 routes/
│   └── web.php                          # Routes (authentification + 4 groupes par rôle)
│
├── 📁 resources/
│   ├── 📁 views/
│   │   ├── 📁 auth/
│   │   │   ├── login.blade.php              # Connexion
│   │   │   └── register.blade.php           # Inscription (user_type optionnel)
│   │   │
│   │   ├── 📁 layouts/
│   │   │   └── app.blade.php                # Layout principal
│   │   │
│   │   ├── 📁 admin/
│   │   │   └── dashboard.blade.php          # Dashboard Admin (tableau utilisateurs, ressources)
│   │   │
│   │   ├── 📁 responsable/
│   │   │   └── dashboard.blade.php          # Dashboard Tech Manager
│   │   │
│   │   ├── 📁 user/
│   │   │   ├── dashboard.blade.php          # Dashboard Utilisateur (avec/sans profil)
│   │   │   ├── history.blade.php            # Historique des réservations
│   │   │   └── create-reservation.blade.php # Formulaire réservation
│   │   │
│   │   ├── 📁 incidents/
│   │   │   └── create.blade.php            # Signalement incident
│   │   │
│   │   ├── 📁 reservations/
│   │   │   └── create.blade.php            # Formulaire réservation
│   │   │
│   │   └── welcome.blade.php                # Accueil public (filtrage équipements)
│   │
│   ├── 📁 css/
│   │   ├── app.css
│   │   ├── login.css
│   │   ├── register.css
│   │   └── style.css
│   │
│   └── 📁 js/
│       ├── app.js
│       ├── bootstrap.js
│       ├── login.js
│       ├── register.js
│       └── home.js
│
├── 📁 public/
│   ├── index.php                        # Point d'entrée
│   ├── robots.txt
│   ├── 📁 css/                          # CSS compilé
│   ├── 📁 js/                           # JS compilé
│   └── 📁 images/
│
├── 📁 bootstrap/
│   ├── app.php
│   ├── providers.php
│   └── 📁 cache/
│
├── 📁 config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php                        # Session: file-based
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php                      # Configuration sessions
│
├── 📁 storage/
│   ├── 📁 app/
│   │   ├── 📁 private/
│   │   └── 📁 public/
│   ├── 📁 framework/
│   │   ├── 📁 cache/
│   │   ├── 📁 sessions/
│   │   ├── 📁 testing/
│   │   └── 📁 views/
│   └── 📁 logs/
│
├── 📁 tests/
│   ├── TestCase.php
│   ├── 📁 Feature/
│   └── 📁 Unit/
│
├── 📁 vendor/
│   └── [Dépendances Composer]
│
└── 📁 docs/
    ├── RAPPORT.md                       # Rapport complet (ce fichier)
    └── STRUCTURE.md                     # Structure détaillée (ce fichier)
```

## 🔑 Fichiers clés et leur rôle

### Controllers

| Fichier | Responsabilité | Clés |
|---------|-----------------|------|
| **LoginController.php** | Authentification | Validation email/password |
| **RegisterController.php** | Inscription | user_type optionnel, role_id = 3 ou 4 |
| **AdminDashboardController.php** | Gestion complète | Stats, users CRUD, resources CRUD, catégories |
| **TechController.php** | Gestion technique | Réservations supervisées, incidents, maintenance |
| **UserDashboardController.php** | Dashboard utilisateur | Filtrage par user_type, restrictions équipements |
| **ReservationController.php** | Réservations | Validation, approbation/refus, notifications |
| **IncidentController.php** | Incidents | Signalement, consultation |
| **ResourceManagerController.php** | Ressources | CRUD, maintenance toggle |

### Models (avec relations)

| Model | Colonnes clés | Relations |
|-------|---------------|-----------|
| **User** | id, name, email, role_id, user_type, status | belongsTo(Role), hasMany(Reservations) |
| **Role** | id, name | hasMany(Users) |
| **Resource** | id, name, category_id, status, cpu, ram, os | belongsTo(Category), hasMany(Reservations) |
| **ResourceCategory** | id, name | hasMany(Resources) |
| **Reservation** | id, user_id, resource_id, status, start_date, end_date | belongsTo(User), belongsTo(Resource) |
| **Incident** | id, resource_id, user_id, description, status | belongsTo(Resource), belongsTo(User) |
| **MaintenancePeriod** | id, resource_id, start_date, end_date, description | belongsTo(Resource) |
| **Notification** | id, user_id, title, message, is_read | belongsTo(User) |

### Migrations (ordre chronologique)

1. **create_roles_table** → 3 rôles initiaux
2. **create_users_table** → Schéma utilisateurs
3. **create_resource_categories_table** → 4 catégories
4. **create_resources_table** → Équipements (50)
5. **create_reservations_table** → Statuts ENUM
6. **create_incidents_table** → Incidents IT
7. **create_notifications_table** → Notifications
8. **add_tech_manager_to_resources** → Supervison
9. **enhance_reservations_table** → Justification, motif refus
10. **create_maintenance_periods_table** → Maintenances
11. **add_user_type_to_users_table** → Types internes (NOT NULL)
12. **make_user_type_nullable_in_users_table** → user_type NULLABLE
13. **add_utilisateur_normal_role** → 4ème rôle
14. **update_user_roles** → Assignation automatique

## 🔄 Flux des données principales

### Flux d'authentification
```
User → Login Form → LoginController → Auth::attempt() → Rôle → Dashboard spécifique
```

### Flux de réservation
```
Utilisateur → Sélection équipement 
           → Vérification restrictions (user_type)
           → Formulaire réservation
           → Validation contrôles de conflit
           → EN ATTENTE
           → Responsable Tech → Approbation/Refus
           → VALIDÉE/REFUSÉE
           → Notification utilisateur
```

### Flux de maintenance
```
Admin → Planification maintenance 
     → Équipement basculé en maintenance
     → Reservations impossibles
     → Fin maintenance → Équipement disponible
```

## 📊 Statistiques du projet

| Métrique | Valeur |
|----------|--------|
| Fichiers controllers | 8 |
| Fichiers models | 8 |
| Migrations | 14+ |
| Routes | 40+ |
| Vues Blade | 10+ |
| Utilisateurs de test | 4 |
| Équipements | 50 |
| Rôles | 4 |
| Catégories | 4 |

## 🔐 Points de sécurité clés

1. **Authentification** (app/Http/Controllers/Auth/)
2. **Middleware RoleMiddleware** (app/Http/Middleware/RoleMiddleware.php)
3. **Validation** dans les controllers
4. **CSRF protection** (@csrf dans les formulaires)
5. **Eloquent ORM** (prévention SQL injection)

## ⚡ Performance

- Migrations indexées sur les clés étrangères
- Eager loading des relations (with())
- Cache fichier pour sessions
- Seeders optimisés (50 items générés rapidement)

---

**Dernière mise à jour** : 28 janvier 2026
