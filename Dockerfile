FROM php:7.2-apache
RUN docker-php-ext-install mysqli && docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
RUN  apt-get -y update \
    && apt-get -y autoremove \
    && apt-get clean \
    && apt-get install -y p7zip \
    p7zip-full \
    zip \
    unzip 
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN mkdir /var/www/html/symfony_study
RUN chmod -R 777 /var/www/html/symfony_study

WORKDIR /var/www/html/symfony_study
COPY . .
RUN composer install

EXPOSE 8000:8000
EXPOSE 80
EXPOSE 443

CMD ["php", "bin/console", "server:run", "0.0.0.0"]