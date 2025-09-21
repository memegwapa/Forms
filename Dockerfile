FROM php:8.2-apache
RUN a2enmod rewrite
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql
COPY . /var/www/html/
WORKDIR /var/www/html/
RUN chmod -R 755 /var/www/html && chown -R www-data:www-data /var/www/html
RUN echo "<IfModule mod_dir.c>\n    DirectoryIndex data.php\n</IfModule>" > /etc/apache2/conf-enabled/directoryindex.conf
EXPOSE 80
