# 🖥️ DataCenter Pro - Gestion d'Infrastructure Informatique

Une application complète de gestion d'infrastructure IT avec système de réservation, gestion des incidents et contrôle d'accès par rôles.

## 📺 Démonstration Vidéo
Le fichier étant trop volumineux (612 Mo), vous pouvez visionner la démonstration complète ici :
👉 **[LIEN VERS TA VIDÉO ICI]**

## 🚀 Installation rapide
1. Cloner le projet ou extraire le ZIP.
2. Lancer la commande de configuration automatique :
   ```bash
   composer run setup
   
## 📋 Vue rapide

```
✅ 4 rôles utilisateurs avec permissions différentes
✅ 50 équipements IT dans 4 catégories
✅ Réservation avec workflow d'approbation
✅ Gestion des maintenances
✅ Système de notifications
✅ Contrôle d'accès granulaire
```

## 🚀 Démarrage rapide

```bash
# Installation
composer install
php artisan migrate
php artisan db:seed --class=DataCenterSeeder

# Serveur local
php artisan serve
```

**Accès** : http://localhost:8000

### Comptes de test

| Rôle | Email | Password |
|------|-------|----------|
| Admin | admin@test.com | admin123 |
| Responsable Tech | tech@test.com | tech123 |
| Utilisateur Interne |ton adresse email|ton password | créer un compte avec un type(ingénieur /doctorant/enseigant)
| Utilisateur Normal | ton adresse email| ton password |  créer un compte avec un type d'utilisateur normal

## 📚 Documentation

- **[Rapport complet](docs/RAPPORT.md)** - Modélisation BD, fonctionnalités, technologies
- **[Structure projet](docs/STRUCTURE.md)** - Organisation des fichiers

## 🛠️ Stack technologique

- **Framework** : Laravel 11+
- **Language** : PHP 8.3.14
- **Base de données** : MySQL 8.0+
- **Frontend** : Blade + CSS3

## 🎨 Design & UI

L'application utilise le moteur de template **Blade** avec un système de design personnalisé :
- **Thème Sombre** : Optimisé pour la réduction de la fatigue visuelle des administrateurs.
- **Accents Indigo** : Utilisation de la couleur `#6366f1` pour une hiérarchie visuelle claire.
- **Responsive** : Tableaux en pleine largeur (Edge-to-Edge) pour une supervision maximale.

## 📊 Architecture

### Rôles et Permissions

```
Admin (Administrateur)
├── Gestion complète des utilisateurs
├── Gestion des ressources et catégories
├── Planification des maintenances
└── Statistiques globales

Responsable Technique
├── Approbation/refus des réservations
├── Gestion des ressources supervisées
├── Signalement d'incidents
└── Basculement en maintenance

Utilisateur Interne (Ingénieur/Doctorant/Enseignant)
├── Réservation de TOUS les équipements
├── Historique des réservations
└── Signalement d'incidents

Utilisateur Normal
├── Réservation équipements standards (VM, Stockage, Réseau)
├── Historique des réservations
└── Signalement d'incidents
```

### Catalogue d'équipements (50 items)

| Catégorie | Quantité | Accessibilité |
|-----------|----------|---------------|
| Serveurs | 15 | Internes uniquement ⛔ |
| VMs | 15 | Tous ✅ |
| Stockage | 10 | Tous ✅ |
| Réseau | 10 | Tous ✅ |

## 📈 Fonctionnalités principales

- ✅ Authentification sécurisée (bcrypt)
- ✅ Gestion complète des utilisateurs
- ✅ Catalogue d'équipements avec spécifications
- ✅ Réservation avec workflow d'approbation
- ✅ Statuts de réservation (EN ATTENTE, VALIDÉE, REFUSÉE)
- ✅ Gestion des incidents
- ✅ Planification des maintenances
- ✅ Notifications en temps réel
- ✅ Filtrage avancé des réservations
- ✅ Dashboard personnalisé par rôle

## 🔐 Sécurité

- Protection CSRF sur tous les formulaires
- Hachage Bcrypt des mots de passe
- Middleware d'authentification
- Middleware de vérification des rôles
- Validation côté serveur
- Protection contre l'injection SQL (Eloquent ORM)

## 📁 Structure des fichiers

```
app/
├── Models/          # Modèles Eloquent
├── Controllers/     # Logique métier
└── Middleware/      # Middleware custom

database/
├── migrations/      # Schéma BD
└── seeders/        # Données de test

resources/views/
├── auth/           # Authentification
├── admin/          # Dashboard Admin
├── responsable/    # Dashboard Tech
└── user/          # Dashboard Utilisateurs

routes/
└── web.php         # Routes de l'application
```

## 🎯 Cas d'usage

### Pour l'Admin
1. Gérer les utilisateurs (CRUD)
2. Gérer le catalogue d'équipements
3. Créer/modifier les catégories
4. Planifier les maintenances
5. Consulter les statistiques

### Pour le Responsable Technique
1. Voir les demandes de réservation
2. Approuver ou refuser les demandes
3. Gérer les ressources supervisées
4. Signaler les incidents
5. Basculer équipements en maintenance

### Pour l'Utilisateur Interne
1. Réserver TOUS les équipements
2. Voir les disponibilités
3. Consulter l'historique
4. Signaler les incidents

### Pour l'Utilisateur Normal
1. Réserver équipements standards uniquement
2. Voir les disponibilités
3. Consulter l'historique
4. Signaler les incidents

## 🚧 Configuration

### Environnement (.env)

```env
APP_NAME=DataCenter Pro
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=datacenter_db
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
```

## 📞 Support

Pour plus d'informations, consultez le [rapport complet](docs/RAPPORT.md).

---

**Version** : 1.0  
**Date** : Janvier 2026  
**Statut** : ✅ Complet et fonctionnel
