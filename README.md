# PanelProduction — Site vitrine (Symfony 7.4)

Projet Symfony pour l’association de production de concerts PanelProduction.
Site public : https://panelproduction.fr/

## Présentation
- Objectif : site vitrine présentant l’association, les groupes, les actualités et les contacts.
- Stack : Symfony 7.4 (LTS), PHP 8.3, MySQL 8.4, Nginx, Webpack Encore, Bootstrap 5.
- Conteneurisation: Docker Compose

Note OS: aujourd’hui la configuration est pensée pour Linux. Sur macOS/Windows (Docker Desktop), il peut être nécessaire de l'ajuster (UID/GID...).

## Prérequis
- Docker et Docker Compose
- Make (facultatif mais recommandé)

## Démarrage rapide (Linux)
```bash
# 1) Démarrer l’infra
make docker-up

# 2) Installer les dépendances PHP
make composer-install

# 3) Préparer la base + migrations + charger les fixtures
make db-reset-fixtures

# 4) Installer les dépendances front
make npm-install

# 5a) Développement (génère public/build localement)
make npm-dev

# 5b) OU lancer le dev-server (HMR) sur http://localhost:8081
make npm-dev-server

# Application disponible via Nginx: http://localhost:8080
```


### Identifiants admin (environnement de développement)
- Email: admin@mail.fr
- Mot de passe: motdepasse



## Données et médias (fixtures)
- Les fixtures créent des enregistrements de démonstration. Les images d’exemple sont copiées dans `public/uploads/...` lorsque c’est nécessaire

## Commandes Make disponibles
- `make docker-up` — démarre les services Docker (PHP, MySQL, Nginx, etc.)
- `make docker-down` — arrête et supprime les services
- `make docker-restart` — redémarre l’infra
- `make composer-install` — installe les dépendances PHP (dans le conteneur PHP)
- `make db-reset-fixtures` — drop/create/migrate + charge les fixtures
- `make npm-install` — installe les dépendances front (npm ci)
- `make npm-dev` — build de développement (écrit dans `public/build`)
- `make npm-build` — build de production
- `make npm-watch` — build de dev en watch
- `make npm-dev-server` — lance le dev-server Encore sur http://localhost:8081

## Roadmap — Décembre 2025
- [x] Passage Symfony 7.4 (LTS)
- [x] Mise à jour des packages et correction des dépréciations principales
- [x] Dockerisation (PHP-FPM, Nginx, MySQL, Node à la demande)
- [x] Mise à jour linters/outillage de base
- [ ] Séparation des responsabilités (controllers minces, services/use cases)
- [ ] Passage systématique aux traductions (i18n) pour labels/messages
- [ ] TESTS automatiques (unitaires + fonctionnels clés) — important car peu de maintenance régulière

## Gros travaux Back à venir (priorisation)
1) Séparation des responsabilités
   - Introduire des services d’application
   - Extraire les accès externes (stockage images, mail) en adapters
2) Internationalisation (translations)
   - Centraliser tous les libellés, messages flash, labels de formulaires
3) Tests
   - Unitaires sur services
4) Sécurité
   - Revoir la configuration `security.yaml` (rôles, access_control), politiques de mots de passe et gestion des comptes par défaut

## TODO Front
1) A voir selon design (relance client)


## TODO (optionnel)
- Hooks Git (pre-commit/pre-push)
  - Lancer PHP-CS-Fixer, PHPStan et tests rapides avant commit/push
- CI légère (GitHub Actions)
  - matrix PHP 8.3; composer validate, phpstan, phpunit, build minimal front
- Déploiement automatisé (cPanel)
    - Étudier les possibilités de déploiement continu via cPanel : Git Deploy, hooks post-receive, scripts de build automatisés, gestion des variables d’environnement, etc.