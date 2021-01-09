#!/bin/sh
set -e

# Enable xdebug by ENV variable
if [ 0 -ne "${PHP_ENABLE_XDEBUG:-0}" ] ; then
    echo "Enabled xdebug"
fi

#cd /var/www && php -S 0.0.0.0:8000 -t public/
cd /var/www && php ./bin/console messenger:consume -vv async