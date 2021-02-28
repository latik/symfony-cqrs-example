FROM php:7-alpine

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    pdo_pgsql \
    mongodb \
    opcache \
;

COPY docker/php/entry_point.sh /entry_point.sh

COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/conf.d $PHP_INI_DIR/conf.d

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www

COPY composer.* /var/www/

RUN composer install --no-interaction --no-scripts --no-dev

COPY . /var/www

RUN set -eux; \
    mkdir -p var/cache var/log; \
    chmod +x bin/console; sync; \
    composer install --optimize-autoloader --no-interaction --no-dev

COPY . /var/www

ENTRYPOINT ["sh", "/entry_point.sh"]