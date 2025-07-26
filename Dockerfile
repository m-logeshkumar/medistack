# Use official PHP with Apache image
FROM php:8.1-apache

# Enable Apache URL rewriting (if needed)
RUN a2enmod rewrite

# Copy project files into web root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/
