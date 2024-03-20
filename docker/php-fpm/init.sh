#!/usr/bin/env bash

# FPM Logs visible from outside without root permissions
logfile=/var/log/php-fpm/error.log
test -f $logfile || touch $logfile

echo "SET FPM LOGS PERMISSIONS"
chmod 644 /var/log/php-fpm/error.log
echo "starting php-fpm..."
exec $@