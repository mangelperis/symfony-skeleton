[![PHP Version](https://img.shields.io/badge/PHP-8.4-blue.svg)](https://www.php.net/)
[![Symfony](https://img.shields.io/badge/Symfony-7.2.6-green.svg)](https://symfony.com/)
[![Nginx](https://img.shields.io/badge/Nginx-1.27.5-009639.svg)](https://hub.docker.com/_/nginx)
[![MariaDB](https://img.shields.io/badge/MariaDB-11.7.2-003545.svg)](https://mariadb.com/)
[![Redis](https://img.shields.io/badge/Redis-7.4.3-DC382D.svg)](https://www.docker.com/blog/how-to-use-the-redis-docker-official-image/)
[![Kafka](https://img.shields.io/badge/Kafka-7.9.0-231F20.svg)](https://github.com/wurstmeister/kafka-docker)
[![MongoDB](https://img.shields.io/badge/MongoDB-8.0.9-47A248.svg)](https://hub.docker.com/_/mongo)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
# PHP & Symfony Docker Stack

## Table of Contents

- [1. Description](#1-description)
  - [Strategy](#strategy)
    - [Structure design](#design-and-principles)
  - [Features](#features)
  - [Improvements](#possible-improvements)
- [2. How to Install and Run the Project](#2-How-to-Install-and-Run-the-Project)
  - [Run using Make commands (recommended)](#run-using-make-commands-recommended)
  - [Run using docker](#run-using-docker-directly-alternative)
    - [Post-Installation setup](#post-installation-setup)
- [3. How to Use the Project](#3-How-to-Use-the-Project)
  - [API](#api)
  - [CLI](#cli)
  - [PHPUnit Testing & Coverage](#phpunit-testing--coverage)
  - [xDebug](#xdebug-debugger)
  - [Docker client host](#__client_host__-)
- [4. Infrastructure](#4-infrastructure-used)
  - [Symfony Packages](#installed-symfony-packages)
- [5. Troubleshooting](#5-troubleshooting)

## 1. Description
With this PHP with Symfony & Docker boilerplate, it's possible to set up a local development environment in seconds.

***

### Strategy
Example: API implementation with Controller that calls a Services.
***
#### Design and Principles
Example: The project structure follows the **hexagonal architecture** of Application, Domain, and Infrastructure.

Design patterns used:
- Dependency Injection (**)
- Entities (**)
- Exception & Logging Handling

Design principles used:
- OOP
- SOLID
***

### Features
The following key features are implemented: ...
***
#### System
***
#### Project
***
#### Good practices
***
#### Logic
***
#### Performance
***

### Possible improvements
***

## 2. How to Install and Run the Project
Copy the environment files to set up your configuration:
```bash
cp ./app/.env.dist ./app/.env && cp .env.dist .env
```

### Run using Make Commands (recommended)
This project includes a Makefile with **convenient commands**:
```
# Start containers
make up                # Start all containers
make kafka             # Start all containers including Kafka services

# Build and rebuild
make build             # Build all containers
make force             # Force rebuild and recreate all containers
make force-kafka       # Force rebuild including Kafka services

# Stop and clean
make down              # Stop all containers (including Kafka)
make clean             # Remove all containers and volumes

# Development tools
make console           # Open bash shell in php-fpm container
make logs              # View live logs from php-fpm container
make ps                # Show running containers

# Quality tools
make quality           # Run all quality checks (fixer, lint, stan)
make fixer             # Run PHP-CS-Fixer
make lint              # Run PHP syntax check
make stan              # Run PHPStan analysis
make cache             # Clear Symfony cache

# Testing
make test-unit         # Run unit tests
make test-integration  # Run integration tests
make test-all          # Run all tests
make coverage          # Generate test coverage report

# Git hooks
make install-hooks     # Install pre-commit hooks
make precommit         # Run pre-commit checks manually
```
***

### Run using docker directly (alternative)
Alternatively to the use of `MAKEFILE`, you can also use Docker commands directly:

* Use `docker compose` to start your environment.
  * Add the _param_ `-d` if you wish to run the process in the background.
  * Add the _param_ `--build` the **first time** to build the images.
  * Add the _keyword_ `down` to stop the containers.
```
# Start containers
docker compose up -d                  # Start regular services
docker compose --profile kafka up -d  # Include Kafka services

# Stop containers
docker compose down
```
***

#### Post-Installation Setup
After starting containers, set up your application:
```
# Install dependencies (first docker build will do this)
docker exec -t php-fpm composer install

# Set up database for development
docker exec -t php-fpm php bin/console doctrine:migrations:migrate --env=dev --no-interaction

# Set up database for testing
docker exec -t php-fpm php bin/console doctrine:database:create --env=test --no-interaction
docker exec -t php-fpm php bin/console doctrine:migrations:migrate --env=test --no-interaction
```
***

##### Container console commands

After booting the containers, you can use this command to enter inside it and execute commands (the container's name is defined in the _**docker-compose.yml**_ file):
```
docker exec -it $container_name bash
```
For the PHP service (php-fpm) you can also use the `make` command:
```bash
make console
```
...or identify the name of it displayed under the column `NAMES` of this command output:
```
docker ps
make ps
```
There's an alias being created upon the build process, and it will allow you to execute the Symfony command directly only with `sf`. Example:
```bash
sf debug:router
```

***

## 3. How to Use the Project
The stack includes these services (check with ``docker ps``):
- [Symfony Web-App welcome page](http://localhost:80)
- [Adminer](http://localhost:8080) - MySQL database manager
- [Mongo Express](http://localhost:8084) - Mongo database manager
- [Redis Admin](http://localhost:8082) - email testing
- [Kafka UI](http://localhost:8083) - when using Kafka profile
- [MailCatcher](http://localhost:1080) - email testing

A `var` folder will be created in the project root containing the server logs to provide help while developing.
***

#### API
Use Postman or another CLI to perform actions on each endpoint.
A [postman collection]() is provided with the project with the source data endpoint and the destination one.

The list of available endpoints can be shown by executing (target **php-fpm** or **php-apache** container):
```
docker exec php-fpm php bin/console debug:router
```
Provided endpoints are (Example):
```
  Name                      Method    Path                          Description
 ------------------------- --------  ----------------------------- --------------------------------
  task_x                    GET|POST /task/x                        Task
  demo_x                    GET      /demo/x                        Demo
```
***
#### CLI
This project provides several Symfony Console commands to interact directly with the XXX domain logic.
These commands allow you to (...explain...) for testing, demos, or automation.

The list of available commands can be shown by executing (target **php-fpm** container):
```
docker exec php-fpm php bin/console list demo
```
Provided commands are (example):
```
  Name                     Description                                    Params (in order)
 ------------------------- ---------------------------------------------- -------------------------------------------------------------------------------------------
  demo:1                   Advance the preparation step of a              Id (UUID)
```

Usage Examples:
* Create a whatever
```bash
php bin/console demo:create-whatever ""
```
Output:
```
Whatever "Something" created with ID 6bd5f063-68f7-4f38-a304-9f967822a644
```
***
#### PHPUnit Testing & Coverage
```
# Run all tests
make test-all

# Run only unit suite
make test-unit

# Run only integration suite
make test-integration

# Generate coverage report
make coverage
```
***

#### xDebug debugger
xDebug (the last version) is installed and ready to use. Check the config params in `/docker/extras/xdebug.ini`
By default, these are the main critical parameters provided:
+ [mode](https://xdebug.org/docs/all_settings#mode) = develop,debug,coverage
+ [client_host*](https://xdebug.org/docs/all_settings#client_host) = host.docker.internal
+ [client_port](https://xdebug.org/docs/all_settings#client_port) = 9003
+ [idekey](https://xdebug.org/docs/all_settings#idekey) = PHPSTORM
+ [log_level](https://xdebug.org/docs/all_settings#log_level) = 0

Please check the [official documentation](https://xdebug.org/docs/all_settings) for more info about them.
Add the call to `xdebug_info()` from any PHP file to show the info panel.

####  __client_host__ (*)
Depending on your environment, it's **required** to add the following to the **_docker-composer.yml_** file to enable
communication between the container and the host machine. By default, this is **ON**.
```
extra_hosts:
    - host.docker.internal:host-gateway
```
If you find it's not working after setting up your IDE, try to comment on section and change the [xDebug.ini file](/docker/extras/xdebug.ini)
accordingly.

***

## 4. Infrastructure used
* Symfony 7.2.6
* Docker
  * PHP 8.4 (w/ opcache & [xDebug](#xdebug-debugger))
  * Nginx 1.27.5
  * MariaDB 11.7.2
  * Redis 7.4.3 (optional) with [phpRedisAdmin](https://github.com/erikdubbelboer/phpRedisAdmin)
  * Kafka with KRaft mode (no ZooKeeper required) (optional)
    * Schema Registry and [Kafka UI](https://github.com/kafbat/kafka-ui)
  * Adminer (optional)
  * MailCatcher (optional)

### Installed Symfony Packages
* **phpunit/phpunit**: testing framework for PHP
* **doctrine/orm**: simplifies database interactions by mapping database tables to PHP objects.
* **doctrine/doctrine-fixtures-bundle**: predefined sets of data used for testing or populating a database with initial data.
* **symfony/http-client**: HTTP client for making HTTP requests and interacting with web services.
* **symfony/validator**: tools for validating data according to predefined rules.
* **symfony/maker-bundle**: facilitates rapid development by automating the creation of boilerplate code.
* **phpstan/phpstan**: analysis tool for PHP code, to detect and fix issues.
* **friendsofphp/php-cs-fixer**: code fixer and beautifier for PHP.

***

## 5. Troubleshooting
If something goes wrong then...
