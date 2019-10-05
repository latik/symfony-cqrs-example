#!/bin/sh
set -e

# Enable xdebug by ENV variable
if [ 0 -ne "${PHP_ENABLE_XDEBUG:-0}" ] ; then
    docker-php-ext-enable xdebug
    echo "Enabled xdebug"
fi

cd /var/www && composer install --optimize-autoloader --no-suggest --no-interaction

#cd /var/www && php ./bin/console server:run 0.0.0.0:8000
cd /var/www && php ./bin/console messenger:consume -vv async