FROM php:5.4-apache
WORKDIR /var/www/html

RUN docker-php-ext-install mysql mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysql mysqli pdo pdo_mysql

COPY my-site.conf /etc/apache2/sites-available

RUN a2enmod rewrite
RUN a2ensite my-site.conf
RUN a2dissite 000-default.conf

RUN service apache2 restart

EXPOSE 80
