# Use official PHP with Apache
FROM php:8.2-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Install PHP extensions needed for MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

# Copy project files into Apache’s web root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Expose Apache default port
EXPOSE 80
