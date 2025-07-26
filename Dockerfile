FROM php:8.1-apache

# Enable Apache mod_rewrite (optional but useful for clean URLs)
RUN a2enmod rewrite

# 🛠️ Install mysqli extension
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy your project files into Apache's root directory
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

EXPOSE 80



