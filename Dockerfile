FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

# Copy project files into Apache's root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Fix permissions
RUN chmod -R 755 /var/www/html \
    && chown -R www-data:www-data /var/www/html

# Force Apache to load data.php by default
RUN echo "<IfModule mod_dir.c>\n    DirectoryIndex data.php\n</IfModule>" \
    > /etc/apache2/conf-enabled/directoryindex.conf

# Expose Apache port
EXPOSE 80
