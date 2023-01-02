.DEFAULT_GOAL := help
.PHONY: help

help: ## Helping devs since 2016
	@cat $(MAKEFILE_LIST) | grep -e "^[\%a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo "For additional commands have a look at the Makefile"

install-ci: ## Install ci
	composer install -d ./ci --no-ansi --no-interaction --no-progress --no-scripts --optimize-autoloader
	composer install --no-ansi --no-interaction --no-progress --no-scripts --optimize-autoloader

install-dev: ## install dev
	composer install -d ./ci
	composer install

install-production: ## Install production
	composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader
	yarnpkg build

install-frontend-dev: ## install frontend dev
	yarnpkg encore dev

install-frontend-prod: ## install frontend production
	yarnpkg encore production

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

ci: composer analyze lint test ## run CI

composer:
	composer validate
	composer outdated --direct
	composer validate -d ./ci
	composer outdated --direct -d ./ci

analyze: analyze-phpstan ## Run all analyzer tools

analyze-deptrac: ## Run deptrac
	./ci/vendor/bin/deptrac analyse --config-file=./ci/config/depfile.yaml --cache-file=./ci/cache/.deptrac.cache

analyze-phpstan: ## run phpstan
	php -d memory_limit=-1 ./ci/vendor/bin/phpstan analyse --configuration ./ci/config/phpstan.neon --xdebug

analyze-phpstan-baseline: ## run phpstan and update the baseline
	php -d memory_limit=-1 ./ci/vendor/bin/phpstan analyse --configuration ./ci/config/phpstan.neon --generate-baseline ./ci/config/phpstan-baseline.neon  --xdebug

analyze-rector: ## Run rector
	php ./ci/vendor/bin/rector process --config=./ci/config/rector.php --xdebug --clear-cache

lint: lint-php ## Runn all lint tools

lint-php: ## cs fixer dry-run
	PHP_CS_FIXER_IGNORE_ENV=1 ./ci/vendor/bin/php-cs-fixer fix --show-progress=dots --diff --dry-run src
	PHP_CS_FIXER_IGNORE_ENV=1 ./ci/vendor/bin/php-cs-fixer fix --show-progress=dots --diff --dry-run tests

lint-php-fix: ## cs fixer
	PHP_CS_FIXER_IGNORE_ENV=1 ./ci/vendor/bin/php-cs-fixer fix --show-progress=dots --diff src
	PHP_CS_FIXER_IGNORE_ENV=1 ./ci/vendor/bin/php-cs-fixer fix --show-progress=dots --diff tests

test: test-php ## Run all tests

test-php: ## Run tests
	./vendor/bin/phpunit -c ./ci/config/phpunit.xml

test-php-coverage: ## Run tests with coverage
	XDEBUG_MODE=coverage ./vendor/bin/phpunit -c ./ci/config/phpunit.xml --coverage-text --coverage-html ./ci/result/phpunit/coverage-html
