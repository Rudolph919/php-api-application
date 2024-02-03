FROM php:8.2-apache

WORKDIR /var/www/html

COPY ./src /var/www/html

# Enable the Apache rewrite module for .htaccess support
RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]
