FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
    docker-php-ext-install mysqli pdo pdo_mysql \
    docker-php-ext-enable pdo_mysql

CMD ["php-fpm"]
