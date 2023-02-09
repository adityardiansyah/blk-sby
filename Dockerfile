#LARAVEL via artisan

FROM thecodingmachine/php:8.1-v4-apache
ARG PHP_VER=8.1

#ENV APACHE_RUN_USER=www-data \
#    APACHE_RUN_GROUP=www-data \
ENV APACHE_DOCUMENT_ROOT=/var/www/public \
    APACHE_EXTENSIONS="request rewrite" \
    PHP_INI_MEMORY_LIMIT=1g \
    PHP_INI_UPLOAD_MAX_FILESIZE=1g \
    PHP_INI_POST_MAX_SIZE=1g \
    PHP_INI_MAX_EXECUTION_TIME=600 \
    PHP_INI_MAX_INTPUT_TIME=600 \
    PHP_EXTENSIONS="gd intl mongodb imagick pdo pgsql pdo_pgsql gettext imap uuid intl bcmath ldap"

RUN sudo apt-get update -y \
    && sudo apt-get install -y \
    php${PHP_VER}-dev \
    php${PHP_VER}-pgsql \
    php${PHP_VER}-mysql \
    pkg-config \
    && sudo pecl config-set php_ini /etc/php/${PHP_VER}/apache2/php.ini \
    && sudo pecl install dbase-7.1.1 \
    && echo "extension=dbase.so" |sudo tee  /etc/php/${PHP_VER}/cli/conf.d/ext-dbase.ini \
    && echo "extension=dbase.so" |sudo tee  /etc/php/${PHP_VER}/apache2/conf.d/ext-dbase.ini

WORKDIR /var/www
COPY --chown=docker:docker . /var/www

RUN sudo chown -R docker:docker /var/www

RUN composer install  \
    && composer update

RUN sudo apt-get install -y nodejs npm

RUN npm install \
    && npm update

RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan route:clear
