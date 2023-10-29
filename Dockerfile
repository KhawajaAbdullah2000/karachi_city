FROM php:8.1-fpm-bullseye

# Arguments defined in docker-compose.yml
##ARG user
##ARG uid

# Install system dependencies
RUN apt update && apt install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
##RUN useradd -G www-data,root -u $uid -d /home/$user $user
##RUN mkdir -p /home/$user/.composer && \
##    chown -R $user:$user /home/$user
##USER $user
# Set working directory
WORKDIR /var/www

COPY ./docker-compose/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
COPY ./docker-compose/wait-for-it.sh /wait-for-it.sh
RUN chmod +x /wait-for-it.sh

# Copying modified php.ini files
COPY ./docker-compose/php.ini-development /usr/local/etc/php/php.ini-development
COPY ./docker-compose/php.ini-production /usr/local/etc/php/php.ini-production
CMD ["/entrypoint.sh"]