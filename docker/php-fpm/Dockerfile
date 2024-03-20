FROM php:8.3.3-fpm

ENV PHP_INI_DIR=/usr/local/etc/php

#Install System Packages
RUN apt-get -y update && apt-get install -y git libicu-dev libzip-dev zip libjpeg-dev libpng-dev libfreetype6-dev libpcre3 libpcre3-dev

# Install vim
RUN apt-get install -y vim

# Extra php extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd --with-jpeg --with-freetype
RUN docker-php-ext-install intl opcache pdo_mysql zip gd
RUN docker-php-ext-enable intl opcache pdo_mysql zip gd

# xdebug 3
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# INI-files
COPY /docker/php-fpm/php-fpm.conf /usr/local/etc/php-fpm.d/zz-log.conf
COPY /docker/extras/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY /docker/extras/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY /docker/extras/php.ini "$PHP_INI_DIR/php.ini"

# xDebug Step Debug enable
RUN echo "xdebug.mode=debug" >> "$PHP_INI_DIR/php.ini"

# Install Composer & Symfony CLI
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

# Enable php-fmp log permission view from host machine
ADD /docker/php-fpm/init.sh /usr/src/init.sh
RUN chmod +x /usr/src/init.sh

WORKDIR /var/www
EXPOSE 9000
ENTRYPOINT ["/usr/src/init.sh","php-fpm","-F"]