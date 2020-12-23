.DEFAULT_GOAL := help
.PHONY: help
REQUIRED_TOOLS := git docker docker-compose
APP_DIR=$(shell basename `pwd`)
VERSION=0.1.0

help: ## helping devs since 2016
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo "For additional commands have a look at the Makefile"

api-%: ## run targets inside container
	docker-compose exec --user $(id -u):$(id -g) php make $*

setup:
	$(MAKE) build
	$(MAKE) api-install
	$(MAKE) api-ci

build: ## build containers and boot
	@$(foreach T,$(REQUIRED_TOOLS),command -v $T || (echo ❌ missing tool: $T; exit 1);)
	docker-compose build
	docker-compose up -d
	docker ps -a

down:
	docker-compose down --rmi all

versions: ## print version of tools
	docker -v
	docker-compose -v

docker-tag-push:
	docker-compose build
	docker-compose push

tag-message: ## create a release changelog
	@git log --grep="Merge pull request" --pretty="%n* %b%n  (%s)" \
		$(shell git tag --sort=-version:refname |  head -n 1) | \
		sed 's/Merge pull request //g'
