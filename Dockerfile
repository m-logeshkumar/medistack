# Use official PHP image with Apache
FROM php:8.1-apache

# Enable Apache rewrite module (important for frameworks or clean URLs)
RUN a2enmod rewrite

# Copy all files into Apache's root directory
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Expose port 80
EXPOSE 80


