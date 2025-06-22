# Use official PHP image with Apache
FROM php:8.1-apache

# Copy all project files to Apache's root directory
COPY . /var/www/html/

# Give necessary permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Enable Apache mod_rewrite (optional for clean URLs)
RUN a2enmod rewrite

EXPOSE 80
