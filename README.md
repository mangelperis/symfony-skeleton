# Docker-Symfony-Stack

## Table of Contents

- [Description](#description)
- [Infrastructure](#infrastructure-used)
  - [Symfony Packages](#installed-symfony-packages)
- [Getting Started](#getting-started)
  - [Run using composer](#run-using-composer)
  - [Run using docker](#run-using-docker)
    - [Next steps](#important)
    - [nginx or apache](#note)
- [How it works?](#how-it-works)
  - [API](#api)
  - [PHPUnit Testing](#phpunit-testing)
  - [xDebug](#xdebug-debugger)
  - [Docker client host](#__client_host__-)
- [Troubleshooting](#troubleshooting)

## Description
With this Docker-Symfony-Stack boilerplate, it's possible to set up a local development environment in seconds.

## Infrastructure used
* Symfony 7
* Docker
  * PHP 8.3 (w/ opcache & [xDebug](#xdebug-debugger))
  * [Nginx / Apache](#note)
  * MariaDB 11.1.4
  * Redis 7.2.4 (optional)
  * Adminer (optional)
  * MailCatcher (optional)

### Installed Symfony Packages
* **phpunit/phpunit**: testing framework for PHP
* **doctrine/orm**: simplifies database interactions by mapping database tables to PHP objects.
* **doctrine/doctrine-fixtures-bundle**: predefined sets of data used for testing or populating a database with initial data.
* **symfony/http-client**: HTTP client for making HTTP requests and interacting with web services.
* **symfony/validator**: tools for validating data according to predefined rules.
* **symfony/maker-bundle**: facilitates rapid development by automating the creation of boilerplate code.
* **phpstan/phpstan**: analysis tool for PHP code, to detect and fix issues,

***

## Getting Started
Copy or rename the `.env.dist` files (for docker and symfony) to an environment variable file and edit the entries to your needs:
```
cp ./app/.env.dist .env
cp ./docker/.env.dist .env
```

### Run using composer

`composer run` commands are provided as **shortcuts**.

Use `composer run setup` to start and initialize all needed containers.

Available commands are:
```
composer run [
    setup             --- Build the docker images and run the containers in the background.
    build             --- Build the docker images.
    up                --- Run the containers in the background.
    down              --- Stop the containers.
    logs              --- Show container sys logs (php-fpm, nginx, and MariaDB).
    cache-clear       --- Execute Symfony clear cache command.
    stan              --- Execute PHPStan analyse command.
    test              --- Execute PHPUnit test cases.    
]
```

A folder named `var` will be created in the project root folder upon the first run. This folder includes the database files and server logs to provide help while developing.

### Run using docker
Alternatively to the use of `composer`, you can directly build & run the app by using the following docker commands:

* Use `docker compose` to start your environment.
  * Add the _param_ `-d` if you wish to run the process in the background.
  * Add the _param_ `--build` the **first time** to build the images.
  * Add the _keyword_ `down` to stop the containers.
```
# Build & up. From the project's root folder exec
docker-compose up -d --build
```

#### IMPORTANT
After booting the container, run `composer install` from outside or inside the container.
```
docker exec -t php-fpm composer install
```
Then run the database migrations to create the mysql structure for both **dev** and **test** environments.
```
docker exec -t php-fpm php bin/console doctrine:migrations:migrate --env=dev --no-interaction
```

```
docker exec -t php-fpm php bin/console doctrine:database:create --env=test --no-interaction
docker exec -t php-fpm php bin/console doctrine:migrations:migrate --env=test --no-interaction
```

After booting the container, you can use this command to enter inside it and execute commands (the container's name is defined in the _**docker-compose.yml**_ file):
```
docker exec -it $container_name bash
```
or identify the name of it displayed under the column `NAMES` of this command output:
```
docker ps
```
There's an alias being created upon the build process, and it will allow you to execute the Symfony command directly only with `sf`. Example:
```
sf debug:router
```

#### Note
Configurations to serve the project with either **NGINX** or **APACHE** servers are provided. By default, NGINX settings will be used.
If you wish to use **APACHE** instead, **rename** the proper _**docker-compose.apache.yml**_ file or specify the target file while using the `up` command.
```
docker compose -f docker-compose.apache.yml up --build
```
***

## How it works?
You have up to 5 containers running depending on whether you choose to use nginx or apache: php-fpm + nginx or php-apache, mariadb, redis, and optionally, adminer.
Check the running containers by using the command: ``docker ps``
- [Symfony Web-App welcome page](http://localhost:80)
- [Adminer [optional] (simple database manager)](http://localhost:8080)
- [MailCatcher [optional] (catches and displays sent mail)](http://localhost:1080)

#### API
Use Postman or another CLI to perform actions on each endpoint.
A [postman collection]() is provided with the project with the source data endpoint and the destination one.

The list of available endpoints can be shown by executing (target **php-fpm** or **php-apache** container):
```
docker exec php-fpm php bin/console debug:router
```
Provided endpoints are (Example):
```
GET|HEAD  api/user/all                  List all users
POST      api/user/create               Create a new user   
PUT       api/user/{user}               Update user by ID
DELETE    api/user/{user}               (Soft) Delete a user by ID
GET|HEAD  api/user/{user}               Show user data by ID
GET|HEAD  api/user/{user}/workentry     List all user WorkEntries by UserID

POST      api/workentry/create          Create a new WorkEntry
PUT       api/workentry/{workentry}     Update WorkEntry by ID
DELETE    api/workentry/{workentry}     Delete WorkEntry by ID
GET|HEAD  api/workentry/{workentry}     Show WorkEntry Data by ID
```

#### PHPUnit Testing
Additionally, run all the tests available using (target **php-fpm** or **php-apache** container):
```
docker exec php-fpm ./vendor/bin/phpunit --verbose
```
or
```
composer test
```

***

#### xDebug debugger
xDebug (the last version) is installed and ready to use. Check the config params in `/docker/extras/xdebug.ini`
By default, these are the main critical parameters provided:
+ [mode](https://xdebug.org/docs/all_settings#mode) = develop,debug
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

## Troubleshooting
Nothing else for now!


