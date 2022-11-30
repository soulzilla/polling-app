FROM cyberduck/php-fpm-laravel:8.1

USER root

WORKDIR /var/www/application

RUN chown -R www-data:www-data /var/www
RUN chmod -R 777 /var/www

RUN cd ~

RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php

RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

COPY testapp/. /var/www/application

RUN cp /var/www/application/.env.example /var/www/application/.env

RUN cd /var/www/application

RUN composer install

RUN php artisan key:generate
