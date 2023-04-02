FROM php:8.2.4-fpm

WORKDIR /app

COPY . .

COPY --from=composer /usr/bin/composer /usr/bin/composer
#
RUN apt update && apt install -y \
    unzip \
    git \
    libpq-dev

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql

RUN chown -R www-data /app
RUN chown -R www-data /var/www
RUN chmod -R 777 /app

USER www-data
