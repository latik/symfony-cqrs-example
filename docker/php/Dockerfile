FROM php:alpine

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    pcntl \
    pdo_pgsql \
    mongodb \
    opcache \
    php-amqp/php-amqp@latest \
;

ARG BUILD_WITH_XDEBUG=0
RUN if [ ${BUILD_WITH_XDEBUG} = 1 ]; then \
   IPE_DONT_ENABLE=1 install-php-extensions xdebug \
;fi

COPY docker/php/entry_point.sh /entry_point.sh

COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/conf.d $PHP_INI_DIR/conf.d

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www

COPY . /var/www

RUN set -eux; \
	mkdir -p var/cache var/log; \
	composer install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction; \
	composer dump-autoload --classmap-authoritative --no-dev; \
	composer symfony:dump-env prod; \
	composer run-script --no-dev post-install-cmd; \
	chmod +x bin/console; sync

ENTRYPOINT ["sh", "/entry_point.sh"]
