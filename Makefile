.DEFAULT_GOAL := help
.PHONY: help

help: ## Helping devs since 2016
	@cat $(MAKEFILE_LIST) | grep -e "^[\%a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo "For additional commands have a look at the Makefile"

database-dump: ## dumps database to a file 
	symfony run pg_dump --data-only > var/dump.sql

database-restore: ## restores the database from a file
	symfony run psql < var/dump.sql