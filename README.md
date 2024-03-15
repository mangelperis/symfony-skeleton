# Docker-Symfony-Stack

With this Docker-Symfony-Stack it's possible to setup a local development environment in seconds.

## Getting started
Copy the .env.dist file and edit the entries to your needs:
```
cd ./docker/
cp .env.dist .env
```

Only start docker-compose to start your environment:
```
cd ./docker/
docker-compose up --build
```

After booting the container, you can use this command to enter inside it and execute commands (container's prefix name is name in docker/.env file):
```
docker exec -it $CONTAINER_NAME_PREFIX-php-apache bash
```

## Installed Packages
You have three container running: PHP-APACHE, MariaDB and optionally, Adminer.
- [Web-App](http://localhost:80)
- [Adminer (simple database manager )](http://localhost:8080)
