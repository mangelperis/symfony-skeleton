### Run using composer (recommended)

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
    coverage          --- Execute PHPUnit test coverage.
]
```
