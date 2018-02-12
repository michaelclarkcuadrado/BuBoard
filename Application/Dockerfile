FROM php:apache
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install exif
COPY src /var/www/html
COPY config/php.ini /usr/local/etc/php/
EXPOSE 80
