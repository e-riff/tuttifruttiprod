# PanelProduction — Site vitrine (Symfony 7.4)

Projet Symfony pour l’association de production de concerts PanelProduction.
Site public : https://panelproduction.fr/

## Présentation
- Objectif : site vitrine présentant l’association, les groupes, les actualités et les contacts.
- Stack : Symfony 7.4 (LTS), PHP 8.4, MySQL 8.4, Nginx, Webpack Encore, Bootstrap 5.
- Conteneurisation: Docker Compose

Note OS: aujourd’hui la configuration est pensée pour Linux. Sur macOS/Windows (Docker Desktop), il peut être nécessaire de l'ajuster (UID/GID...).

## Architecture

Le projet utilise une architecture inspirée DDD / hexagonale, volontairement légère. Le but n’est pas de faire du DDD “pur”, mais de garder les bénéfices de Symfony et Doctrine sur un petit site vitrine, tout en isolant progressivement les responsabilités.

La racine `src/` est organisée en trois zones principales :

- `Domain/` : vocabulaire métier indépendant des détails techniques, notamment les enums métier et les interfaces de repository.
- `Application/` : cas d’usage applicatifs et ports non-repository.
- `Infrastructure/` : détails d’exécution Symfony, Doctrine, mail, SEO, Twig, fixtures, upload, forms, controllers et listeners.

`src/Kernel.php` reste à la racine car c’est le point d’entrée Symfony standard.

Ce choix est pragmatique : les entités Doctrine/Vich restent le modèle persistant principal, pour conserver l’intégration naturelle avec Doctrine ORM, Symfony Forms, VichUploader et un éventuel API Platform plus tard. Le découplage se fait par les use cases, les ports et les adapters, sans dupliquer tout le modèle métier.

Les controllers sont volontairement dans `Infrastructure/Symfony/Controller` : ce sont des adapters HTTP dépendants de Symfony, Twig, Form, redirects et flashes. Ils restent minces et délèguent à `Application` quand une logique applicative existe.

Une explication détaillée des choix, des ports, des interfaces de repository et des fuites assumées entre couches se trouve dans [ARCHITECTURE.md](ARCHITECTURE.md).

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



## Déploiement cPanel

Après avoir tiré la dernière version du dépôt via l’interface VCS de cPanel, se connecter en SSH puis aller dans le dossier du projet :

```bash
cd repositories/panelproduction.fr/
```


Installer ou mettre à jour les dépendances PHP, appliquer les migrations, générer les assets, puis reconstruire le cache Symfony :

```bash
composer install --no-dev --optimize-autoloader
php bin/console doctrine:migrations:migrate --no-interaction
npm install
npm run build
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod
```

Vérifier ensuite l’état des migrations :

```bash
php bin/console doctrine:migrations:status
```

Points d’attention :
- Le fichier `.env.local` du serveur doit contenir le `DATABASE_URL` de production/cPanel, pas la valeur Docker `mysql:3306`.
- Si `npm` n’est pas disponible sur cPanel, construire les assets ailleurs et déployer le contenu généré de `public/build`.
- Ne pas lancer `db-reset-fixtures` en production : cette commande supprime et recrée la base.

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
- `make install-git-hooks` — active les hooks Git versionnés du projet

## Hooks Git

Le projet fournit un hook `pre-commit` versionné dans `.githooks/pre-commit`.

Installation locale :

```bash
make install-git-hooks
```

Avant chaque commit, le hook lance les vérifications PHP :

- `make cs-check`
- `make cs-stan`

Ces commandes utilisent le service Docker PHP. Il faut donc que l’environnement Docker soit démarré avant de committer.

## Roadmap — Décembre 2025
- [x] Passage Symfony 7.4 (LTS)
- [x] Mise à jour des packages et correction des dépréciations principales
- [x] Dockerisation (PHP-FPM, Nginx, MySQL, Node à la demande)
- [x] Mise à jour linters/outillage de base
- [x] Séparation des responsabilités (Domain / Application / Infrastructure)
- [x] Passage systématique aux traductions (i18n) pour labels/messages
- [ ] TESTS automatiques (unitaires + fonctionnels clés) — important car peu de maintenance régulière

## Gros travaux Back à venir (priorisation)
1) Renforcer les tests
   - Ajouter des tests fonctionnels sur homepage, groupes, contact, admin médias
   - Ajouter des tests unitaires sur les cas d’usage `Application`
2) ~~Internationalisation (translations)~~
   ~~- Centraliser tous les libellés, messages flash, labels de formulaires~~
3) Sécurité
   - Revoir la configuration `security.yaml` (rôles, access_control), politiques de mots de passe et gestion des comptes par défaut
4) Architecture
   - Continuer à extraire des use cases seulement quand une logique dépasse le simple CRUD Symfony
   - Éviter de dupliquer les entités Doctrine tant que le domaine ne justifie pas un modèle séparé

## TODO Front
1) La homepage sert de première proposition de direction UI modernisée.
2) Étendre ou ajuster cette direction sur les autres pages selon les retours client.


## TODO (optionnel)
- CI légère (GitHub Actions)
  - matrix PHP 8.4; composer validate, phpstan, phpunit, build minimal front
- Déploiement automatisé (cPanel)
    - Étudier les possibilités de déploiement continu via cPanel : Git Deploy, hooks post-receive, scripts de build automatisés, gestion des variables d’environnement, etc.
