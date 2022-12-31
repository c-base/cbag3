.DEFAULT_GOAL := help
.PHONY: help

help: ## Helping devs since 2016
	@cat $(MAKEFILE_LIST) | grep -e "^[\%a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo "For additional commands have a look at the Makefile"

install: ## install
	./bin/composer install
	./bin/composer install -d ./devops/ci

install-production:
	composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader
	composer dump-env prod
	yarnpkg build

dev-start: ## start dev env
	./bin/symfony server:start -d
dev-stop: ## stop dev env
	./bin/symfony server:stop

data-restore: ## drop and restore data
	#rm -f ./migrations/*
	./bin/console doctrine:database:drop --force --quiet
	./bin/console doctrine:database:create --if-not-exists --quiet
	#./bin/console doctrine:migrations:di --no-interaction --quiet
	./bin/console doctrine:migrations:migrate --no-interaction --quiet
	./bin/console cbag:restore

database-setup:
	./bin/console doctrine:migrations:migrate

database-dump: ## dumps database to a file 
	./bin/symfony run pg_dump --data-only > var/dump.sql

database-restore: ## restores the database from a file
	./bin/symfony run psql < var/dump.sql

frontend-dev: ## install frontend dev
	yarn encore dev

frontend-prod: ## install frontend production
	yarn encore production

ci: composer analyze-phpstan lint test ## run CI

composer:
	./bin/composer validate
	./bin/composer outdated --direct
	./bin/composer validate -d ./devops/ci
	./bin/composer outdated --direct -d ./devops/ci

analyze: analyze-phpstan ## Run all analyzer tools

analyze-deptrac: ## Run deptrac
	./devops/ci/vendor/bin/deptrac analyse --config-file=./devops/ci/config/depfile.yaml --cache-file=./devops/ci/cache/.deptrac.cache

analyze-phpstan: ## run phpstan
	php -d memory_limit=-1 ./devops/ci/vendor/bin/phpstan analyse --configuration ./devops/ci/config/phpstan.neon --xdebug

analyze-phpstan-baseline: ## run phpstan and update the baseline
	php -d memory_limit=-1 ./devops/ci/vendor/bin/phpstan analyse --configuration ./devops/ci/config/phpstan.neon --generate-baseline ./devops/ci/config/phpstan-baseline.neon

analyze-rector: ## Run rector
	php devops/ci/vendor/bin/rector process --config=devops/ci/config/rector.php --xdebug --clear-cache

lint: lint-php ## Runn all lint tools

lint-php: ## cs fixer dry-run
	PHP_CS_FIXER_IGNORE_ENV=1 ./devops/ci/vendor/bin/php-cs-fixer fix --show-progress=dots --diff --dry-run src
	PHP_CS_FIXER_IGNORE_ENV=1 ./devops/ci/vendor/bin/php-cs-fixer fix --show-progress=dots --diff --dry-run tests

lint-php-fix: ## cs fixer
	PHP_CS_FIXER_IGNORE_ENV=1 ./devops/ci/vendor/bin/php-cs-fixer fix --show-progress=dots --diff src
	PHP_CS_FIXER_IGNORE_ENV=1 ./devops/ci/vendor/bin/php-cs-fixer fix --show-progress=dots --diff tests

test: test-php ## Run all tests

test-php: ## Run tests
	./vendor/bin/phpunit -c ./devops/ci/config/phpunit.xml

test-php-coverage: ## Run tests with coverage
	XDEBUG_MODE=coverage ./vendor/bin/phpunit -c ./devops/ci/config/phpunit.xml --coverage-text --coverage-html ./devops/ci/result/phpunit/coverage-html

push:
	docker-compose tag artefactguide ghcr.io/c-base/cbag3:latest

build-dev:
	docker build -f ./devops/docker/frankenphp/Dockerfile --target dev -t ghcr.io/c-base/cbag3:dev-latest .

build-production:
	docker build -f ./devops/docker/frankenphp/Dockerfile --target production -t ghcr.io/c-base/cbag3:prod-latest-2 .

lint-docker: ## Lint Dockerfiles
	cat ./devops/docker/frankenphp/Dockerfile | docker run --rm -i hadolint/hadolint || true