include .env
include app/.env

# ----------- VARIABLES ------------------------------------------------------------------------------------------------
TEST_COMPOSE_FILE := docker-compose-test.yml #test services compose file

# ----------- END VARIABLES --------------------------------------------------------------------------------------------
# ----------- TESTING --------------------------------------------------------------------------------------------------
test-up:
	$(call print_verbose,"Starting test services...")
	docker compose -f $(TEST_COMPOSE_FILE) up -d --wait

test-down:
	$(call print_verbose,"Stopping test services...")
	docker-compose -f $(TEST_COMPOSE_FILE) down -v

test-integration: test-up
	$(call print_verbose,"Running integration tests...")
	docker exec -t php-fpm vendor/bin/phpunit --testsuite integration
	$(MAKE) test-down

test-unit:
	$(call print_verbose,"Running unit tests...")
	# TODO: phpunit unit only
	docker exec -t php-fpm vendor/bin/phpunit --testsuite unit

test-all: test-unit test-integration
# ----------- END TESTING ----------------------------------------------------------------------------------------------

# Function to print messages based on VERBOSE
define print_verbose
	$(if $(filter true,$(VERBOSE)),@echo $1)
endef

# ----------- BEGIN Docker ---------------------------------------------------------------------------------------------
# Start all containers in detached mode
up:
	docker compose up -d

# Build all containers
build:
	docker compose build

# Force rebuild and recreate all containers
force:
	docker compose up -d --build --force-recreate

# Stop all containers
down:
	docker compose down

# Show running containers
ps:
	docker compose ps

# Remove all containers and volumes
clean:
	docker compose down -v --remove-orphans

# Keep the live tail of container logs
logs:
	docker logs -f --tail 30 php-fpm

console:
	docker exec -it php-fpm bash
# ----------- END DOCKER -----------------------------------------------------------------------------------------------

# ----------- BEGIN QUALITY TOOLS --------------------------------------------------------------------------------------
fixer:
	docker exec php-fpm sh -c "PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix /var/www/src"

lint:
	docker exec php-fpm php -l /var/www/src

stan:
	docker exec php-fpm vendor/bin/phpstan analyse /var/www/src

quality: fixer lint stan
	@echo "All quality checks completed"

precommit:
	pre-commit run --all-files

install-hooks:
	pre-commit clean && \
	pre-commit install

cache:
	docker exec -t php-fpm bin/console cache:clear
# ----------- END QUALITY TOOLS ----------------------------------------------------------------------------------------

# ----------- BEGIN PHONY ----------------------------------------------------------------------------------------------
.PHONY: test-up test-down test-integration test-unit test-all up build force down ps clean logs console \
		fixer lint stan quality precommit install-hooks cache
# ----------- END PHONY ------------------------------------------------------------------------------------------------
