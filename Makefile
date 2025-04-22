# Makefile – Symfony 6.4 PROD
SHELL := /bin/bash
.SHELLFLAGS := -eu -o pipefail -c

#––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
# Variables DRY
PHP               := php
COMPOSER          := composer
CONSOLE           := bin/console
YARN              := yarn
NODE_MODULES      := node_modules
BUILD_DIR         := public/build
CKEDITOR_VERSION  := 4.22.0

.PHONY: help install composer-install migrations assets webpack \
        symlinks cache clear-cache warmup deploy

#––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
help:
	@echo "Usage: make [target]"
	@echo ""
	@echo "Targets disponibles :"
	@echo "  install            = composer-install migrations assets symlinks cache"
	@echo "  composer-install   = Installe deps PHP en prod"
	@echo "  migrations         = Applique les migrations Doctrine"
	@echo "  assets             = Installe JS/CSS (Webpack Encore + CKEditor)"
	@echo "  symlinks           = assets:install avec symlinks"
	@echo "  cache              = clear-cache + warmup"
	@echo "  clear-cache        = Symfony cache:clear --env=prod"
	@echo "  warmup             = Symfony cache:warmup --env=prod"
	@echo "  deploy             = alias pour install"

#––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––
install: composer-install migrations assets symlinks cache

# – Composer
composer-install:
	@echo "→ Installation Composer (prod optimisé)…"
	$(COMPOSER) install \
	  --no-dev \
	  --optimize-autoloader \
	  --classmap-authoritative

# – Migrations
migrations:
	@echo "→ Exécution des migrations Doctrine…"
	$(PHP) $(CONSOLE) doctrine:migrations:migrate \
	  --no-interaction \
	  --env=prod

# – Assets (Webpack Encore + CKEditor)
assets:
	@echo "→ Installation des dépendances JS…"
	$(YARN) install --frozen-lockfile
	@echo "→ Ajout CKEditor v$(CKEDITOR_VERSION) (pour éviter le bug/a­vertissement)…"
	# style Yoda : valeur à gauche dans la condition
	if [ "$(CKEDITOR_VERSION)" = "" ]; then \
	  echo "Erreur : CKEDITOR_VERSION non renseignée" >&2; exit 1; \
	fi
	$(YARN) add --exact ckeditor4@$(CKEDITOR_VERSION)
	@echo "→ Build Webpack Encore (prod)…"
	$(YARN) encore production

# – Symlinks d’assets
symlinks:
	@echo "→ Création des symlinks d’assets…"
	$(PHP) $(CONSOLE) assets:install public \
	  --symlink --relative --env=prod

# – Cache
cache: clear-cache warmup

clear-cache:
	@echo "→ Vide le cache prod…"
	$(PHP) $(CONSOLE) cache:clear \
	  --env=prod --no-warmup

warmup:
	@echo "→ Warmup du cache prod…"
	$(PHP) $(CONSOLE) cache:warmup --env=prod

# – Déploiement global
deploy: install
	@echo "✅ Déploiement terminé !"
