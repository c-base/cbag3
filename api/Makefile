.DEFAULT_GOAL := help
.PHONY: help
APP_DIR=$(shell basename `pwd`)

help: ## helping devs since 2016
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo "For additional commands have a look at the Makefile"

install: ## install dependencies and setup storage
	$(MAKE) install-dependencies
	$(MAKE) install-db

install-dependencies: ## install php dependencies
	composer validate --no-check-publish --strict
	@if [ -n "$(TRAVIS)" && "$(JOB)" = "release" ]; then \
		composer install --no-suggest --prefer-dist --classmap-authoritative --no-dev; \
		composer dumpautoload; \
	else \
		composer install --no-suggest --prefer-dist; \
	fi

install-db: ## setup database
	bin/console doctrine:database:create --if-not-exists --no-interaction
	bin/console doctrine:schema:update --force --no-interaction

ci: ## run all continuous integration tests
	$(MAKE) test
	$(MAKE) -k test-style
	$(MAKE) -k test-static
	$(MAKE) -k test-security


test: ## Run all the unit tests
	vendor/bin/phpunit -c phpunit.xml.dist

test-style:
	./vendor/bin/phpmd src,tests text ./phpmd.xml
	./vendor/bin/phpcs --config-set ignore_warnings_on_exit 1
	./vendor/bin/phpcs --colors --standard=PSR2 src tests

test-static:
	sh -c 'if [[ ! -f /root/.composer/vendor/bin/phpstan ]]; then composer global require phpstan/phpstan:^0.9 --classmap-authoritative --no-suggest --prefer-dist; fi'
	/root/.composer/vendor/bin/phpstan analyse --level=1 ./src

test-security:
	bin/console security:check

fix-style:
	@if [ -z "$(TRAVIS)" ]; then\
		echo Running locally, attempt to fix style issues ...;\
		./vendor/bin/php-cs-fixer fix --dry-run --no-ansi src;\
		./vendor/bin/php-cs-fixer fix --dry-run --no-ansi tests;\
		./vendor/bin/phpcbf --colors --standard=PSR2 --tab-width=4 src tests config;\
	else\
		./vendor/bin/php-cs-fixer fix --no-ansi src;\
		./vendor/bin/php-cs-fixer fix --no-ansi tests;\
		./vendor/bin/phpcbf --colors --standard=PSR2 --tab-width=4 src tests config;\
	fi

clear:
	bin/console cache:clear --env=dev
	bin/console cache:clear --env=test
	bin/console cache:clear --env=prod

fix-permission:
	chown -R 1000:1000 src
	chown -R 1000:1000 config
	chown -R 1000:1000 vendor
	chown -R www-data:www-data var

