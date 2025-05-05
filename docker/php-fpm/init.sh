#!/usr/bin/env bash

# FPM Logs visible from outside without root permissions
logfile=/var/log/php-fpm/error.log
test -f $logfile || touch $logfile

echo "SET FPM LOGS PERMISSIONS"
chmod 644 /var/log/php-fpm/error.log

# Check if vendor directory exists or is empty
if [ ! -d /var/www/vendor ] || [ -z "$(ls -A /var/www/vendor)" ]; then
    echo "Running composer install..."
    cd /var/www && composer install --no-interaction
else
    echo "Vendor directory already exists, skipping composer install"
fi

echo "starting php-fpm..."
exec $@
