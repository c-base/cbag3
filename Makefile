.DEFAULT_GOAL := help
.PHONY: help

help: ## Helping devs since 2016
	@cat $(MAKEFILE_LIST) | grep -e "^[\%a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo "For additional commands have a look at the Makefile"

install: ## install
	./bin/composer install
	cd devops-ci && ./../bin/composer install

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

frontend-dev:
	yarn encore dev

frontend-prod:
	yarn encore production

ci: composer phpstan cs-fix-dry test ## run CI

composer:
	./bin/composer validate
	./bin/composer outdated --direct

phpstan: ## run phpstan
	./devops-ci/vendor/bin/phpstan analyse -l 4 src
	./devops-ci/vendor/bin/phpstan analyse -l 4 tests

cs-fix-dry:
	./devops-ci/vendor/bin/php-cs-fixer fix --show-progress=dots --diff --dry-run src
	./devops-ci/vendor/bin/php-cs-fixer fix --show-progress=dots --diff --dry-run tests

cs-fix:
	./devops-ci/vendor/bin/php-cs-fixer fix --show-progress=dots --diff src
	./devops-ci/vendor/bin/php-cs-fixer fix --show-progress=dots --diff tests

test:
	./vendor/bin/phpunit -c phpunit.xml.dist