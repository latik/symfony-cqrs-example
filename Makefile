DOCKER-COMPOSE	= docker-compose -f docker-compose.yml
EXEC_APP 		= $(DOCKER-COMPOSE) exec app
SYMFONY 		= $(EXEC_APP) bin/console

build: ## build project docker containers
	$(DOCKER-COMPOSE) build #--no-cache

start: ## start the project
	$(DOCKER-COMPOSE) up -d

stop: ## stop the project
	$(DOCKER-COMPOSE) stop

destroy: ## removes containers, networks, volumes, and images
	$(DOCKER-COMPOSE) down --volumes --remove-orphans

vendors: ## install composer dependencies
	$(EXEC_APP) composer install --no-interaction

db: ## reset the database
	$(SYMFONY) doctrine:database:drop --if-exists --force
	$(SYMFONY) doctrine:database:create
	$(SYMFONY) doctrine:schema:create

shell: ## start shell in the app container
	$(EXEC_APP) sh

.DEFAULT_GOAL := help

help:
	@echo "Please choose a task:"
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## /{printf "\033[32m%-18s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)
.PHONY: help