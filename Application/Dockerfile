FROM php:apache
RUN docker-php-ext-install mysqli
COPY src /var/www/html
COPY config/php.ini /usr/local/etc/php/

