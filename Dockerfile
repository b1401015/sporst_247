FROM php:8.2-fpm

# Install necessary PHP extensions for MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install GD dependencies and configure
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd exif


# Install ZIP extension
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

# Install intl extension
RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install intl    

# Set proper permissions
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data \
&& mkdir -p /var/www/html/application/logs \
&& chown -R www-data:www-data /var/www/html \
&& chmod -R 755 /var/www/html 

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
# Set working directory
WORKDIR /var/www/html

# Copy and set entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Đảm bảo script có quyền thực thi trong image
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Dùng tên script (nằm trong PATH: /usr/local/bin)
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
