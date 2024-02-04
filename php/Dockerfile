FROM php:8.2-apache

WORKDIR /var/www/html

COPY ./src /var/www/html

RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    docker-php-ext-enable mysqli pdo_mysql

# Enable the Apache rewrite module for .htaccess support
RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]
