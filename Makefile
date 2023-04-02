.DEFAULT_GOAL := help
.PHONY: help

help: ## Helping devs since 2016
	@cat $(MAKEFILE_LIST) | grep -e "^[\%a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo "For additional commands have a look at the Makefile"

app-%:
	docker compose exec artefactguide make $*

init: build-dev up app-install-dev app-install-frontend-dev app-data-restore ## Init the development environment

up: ## Start all containers
	docker compose up -d

push:
	docker-compose tag artefactguide ghcr.io/c-base/cbag3:latest

build-dev: ## Build image for development
	docker build -f ./devops/docker/frankenphp/Dockerfile --target dev -t ghcr.io/c-base/cbag3:dev-latest .

build-production:  ## Build image for production
	docker build -f ./devops/docker/frankenphp/Dockerfile --target production -t ghcr.io/c-base/cbag3:latest .

lint-docker: ## Lint Dockerfiles
	cat ./devops/docker/frankenphp/Dockerfile | docker run --rm -i hadolint/hadolint || true