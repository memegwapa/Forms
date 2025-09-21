# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install PHP extensions for MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

# Set working directory
WORKDIR /var/www/html/

# Copy project files into Apache's root
COPY . /var/www/html/

# Fix permissions
RUN chmod -R 755 /var/www/html \
    && chown -R www-data:www-data /var/www/html

# Force Apache to load data.php by default
RUN echo "<IfModule mod_dir.c>\n    DirectoryIndex data.php\n</IfModule>" \
    > /etc/apache2/conf-enabled/directoryindex.conf

# Expose Apache port
EXPOSE 80

# Set environment variables (optional default values)
ENV DB_HOST=mysql
ENV DB_USER=root
ENV DB_PASS=
ENV DB_NAME=data_connector

# Start Apache in foreground
CMD ["apache2-foreground"]
