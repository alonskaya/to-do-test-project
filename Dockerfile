FROM php:7.2-fpm-alpine

ARG WITH_XDEBUG=false

RUN apk add --update --no-cache \
        bash \
    && docker-php-ext-install \
        mysqli \
        pdo \
        pdo_mysql \
        bcmath \
    && docker-php-ext-enable \
        pdo_mysql

RUN if [ "${WITH_XDEBUG}" = "true" ] ; then \
        apk add --update --no-cache $PHPIZE_DEPS; \
        pecl install xdebug; \
        docker-php-ext-enable xdebug; \
        echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_enable = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_autostart = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_handler = dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_port = 9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_mode = req" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
fi ;

RUN chown -R www-data:www-data /var/www
COPY --chown=www-data:www-data . /var/www/

USER www-data
WORKDIR /var/www