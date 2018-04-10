.DEFAULT_GOAL := help
.PHONY: help
REQUIRED_TOOLS := git docker docker-compose
APP_DIR=$(shell basename `pwd`)

help: ## helping devs since 2016
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo "For additional commands have a look at the Makefile"

build: ## build containers and boot
	@$(foreach T,$(REQUIRED_TOOLS),command -v $T || (echo ❌ missing tool: $T; exit 1);)
	docker-compose build
	docker-compose up -d
	docker ps -a

install: ## install dependencies and setup storage
	$(MAKE) install-dependencies
	$(MAKE) install-db

install-dependencies: ## install php dependencies
	docker-compose exec php composer validate --no-check-publish --strict
	@if [ -n "$(TRAVIS)" && "$(JOB)" = "deploy" ]; then \
		docker-compose exec php composer install --no-suggest --prefer-dist --classmap-authoritative --no-dev; \
		docker-compose exec php composer dumpautoload; \
	else \
		docker-compose exec php composer install --no-suggest --prefer-dist; \
	fi

install-db: ## setup database
	docker-compose exec php bin/console doctrine:database:create --if-not-exists --no-interaction
	docker-compose exec php bin/console doctrine:schema:update --force --no-interaction

ci: ## run all continuous integration tests
	$(MAKE) versions
	$(MAKE) test
	$(MAKE) test-style
	$(MAKE) test-static
	$(MAKE) test-security

versions:
	docker -v
	docker-compose -v

test: ## Run all the unit tests
	docker-compose exec php vendor/bin/phpunit -c phpunit.xml.dist

test-style:
	docker-compose exec php ./vendor/bin/phpmd src,tests text ./phpmd.xml
	docker-compose exec php ./vendor/bin/phpcs --config-set ignore_warnings_on_exit 1
	docker-compose exec php ./vendor/bin/phpcs --colors --standard=PSR2 src tests

test-static:
	docker-compose exec php sh -c 'if [[ ! -f /root/.composer/vendor/bin/phpstan ]]; then composer global require phpstan/phpstan:^0.9 --classmap-authoritative --no-suggest --prefer-dist; fi'
	docker-compose exec -T php /root/.composer/vendor/bin/phpstan analyse --level=1 ./src

test-security:
	docker-compose exec -T php bin/console security:check

fix-style:
	@if [ -z "$(TRAVIS)" ]; then\
		echo Running locally, attempt to fix style issues ...;\
		docker-compose exec php ./vendor/bin/php-cs-fixer fix --dry-run --no-ansi src;\
		docker-compose exec php ./vendor/bin/php-cs-fixer fix --dry-run --no-ansi tests;\
		docker-compose exec php ./vendor/bin/phpcbf --colors --standard=PSR2 --tab-width=4 src tests config;\
	else\
		docker-compose exec php ./vendor/bin/php-cs-fixer fix --no-ansi src;\
		docker-compose exec php ./vendor/bin/php-cs-fixer fix --no-ansi tests;\
		docker-compose exec php ./vendor/bin/phpcbf --colors --standard=PSR2 --tab-width=4 src tests config;\
	fi

clear:
	docker-compose exec -T php bin/console cache:clear --env=dev
	docker-compose exec -T php bin/console cache:clear --env=test
	docker-compose exec -T php bin/console cache:clear --env=prod

fix-permission:
	docker-compose exec -T php chown -R 1000:1000 src
	docker-compose exec -T php chown -R 1000:1000 config
	docker-compose exec -T php chown -R 1000:1000 vendor

tag-message: ## create a release changelog
	@git log --grep="Merge pull request" --pretty="%n* %b%n  (%s)" \
		$(shell git tag --sort=-version:refname |  head -n 1) | \
		sed 's/Merge pull request //g'
