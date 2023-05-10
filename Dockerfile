FROM php:8.1.12-apache


# la extesion gd parece necesaria, al momento de correr composer install

RUN apt-get update && apt-get install -y \
    libpng-dev  \
    libgmp10    \
    libgmp-dev  \
    libmpfr-dev \
    && docker-php-ext-install pdo pdo_mysql sockets gd gmp bcmath \
    && apt-get clean


RUN curl -sS https://getcomposer.org/installer​ | php -- \
    --install-dir=/usr/local/bin --filename=composer --version=2.5.4

COPY --from=composer:2.5.4 /usr/bin/composer /usr/bin/composer


# definimos DocumentRoot del proyecto
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# enable the Apache rewrite module
# habilitamos el modulo rewrite de Apache
RUN a2enmod rewrite

RUN service apache2 restart

WORKDIR /var/www/html
COPY . /var/www/html

# ADD comedores.sql /docker-entrypoint-initdb.d

EXPOSE 9300
EXPOSE 3333
# CMD ["httpd-foreground"]
