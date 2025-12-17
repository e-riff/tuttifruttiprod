DC = docker compose

# Services
PHP_SVC = php
NODE_SVC = node
NGINX_SVC = nginx
MYSQL_SVC = mysql

# Helper to exec in containers
DEXEC = $(DC) exec
DRUN = $(DC) run --rm

.PHONY: help
help:
	@echo "Cibles disponibles:"
	@echo "  docker-up            -> démarre les services"
	@echo "  docker-down          -> arrête et supprime les services"
	@echo "  docker-restart       -> redémarre les services"
	@echo "  composer-install     -> installe les dépendances Composer (dans le conteneur PHP)"
	@echo "  db-reset-fixtures    -> recrée la base (drop/create/migrate) + charge les fixtures"
	@echo "  npm-install          -> npm ci (dans le conteneur Node)"
	@echo "  npm-build            -> build de prod (Encore production)"
	@echo "  npm-dev              -> build de dev (Encore dev)"
	@echo "  npm-watch            -> watch (Encore dev --watch)"
	@echo "  npm-dev-server       -> démarre le dev-server (expose 8080)"
	@echo "  make-stan            -> lance PHPStan (analyse)"
	@echo "  cs-all               -> exécute php-cs-fixer (fix) puis PHPStan"
	@echo "  cs-check             -> vérifie le code avec PHP-CS-Fixer (dry-run + --diff)"
	@echo "  cs-fix               -> applique les corrections PHP-CS-Fixer"

.PHONY: docker-up
docker-up:
	$(DC) up -d --remove-orphans

.PHONY: docker-down
docker-down:
	$(DC) down --remove-orphans

.PHONY: docker-restart
docker-restart: docker-down docker-up

# Composer
.PHONY: composer-install
composer-install:
	$(DEXEC) $(PHP_SVC) composer install --no-interaction --prefer-dist

# Doctrine: drop/create/migrate + fixtures sans interaction
.PHONY: db-reset-fixtures
db-reset-fixtures:
	$(DEXEC) $(PHP_SVC) php bin/console doctrine:database:drop --force --if-exists --no-interaction
	$(DEXEC) $(PHP_SVC) php bin/console doctrine:database:create --no-interaction
	$(DEXEC) $(PHP_SVC) php bin/console doctrine:migrations:migrate --no-interaction
	$(DEXEC) $(PHP_SVC) php bin/console doctrine:fixtures:load --no-interaction

# Node / Webpack Encore via conteneur Node
.PHONY: npm-install
npm-install:
	$(DRUN) $(NODE_SVC) npm ci

.PHONY: npm-build
npm-build:
	$(DRUN) $(NODE_SVC) npm run build

.PHONY: npm-dev
npm-dev:
	$(DRUN) $(NODE_SVC) npm run dev

.PHONY: npm-watch
npm-watch:
	$(DRUN) $(NODE_SVC) npm run watch

# Dev-server accessible sur http://localhost:8081 si besoin; on force l'écoute 0.0.0.0
.PHONY: npm-dev-server
npm-dev-server:
	$(DC) run --rm -p 8081:8080 $(NODE_SVC) bash -lc "npx encore dev-server --host 0.0.0.0 --port 8080"

# PHP-CS-Fixer
.PHONY: cs-check
cs-check:
	$(DEXEC) $(PHP_SVC) php -d memory_limit=-1 vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --dry-run --diff

.PHONY: cs-fix
cs-fix:
	$(DEXEC) $(PHP_SVC) php -d memory_limit=-1 vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php

# PHPStan
.PHONY: cs-stan
cs-stan:
	$(DEXEC) $(PHP_SVC) php -d memory_limit=-1 vendor/bin/phpstan analyse -c phpstan.neon

# Tout en un: fixer le CS puis lancer PHPStan
.PHONY: cs-all
cs-all: cs-fix make-stan
