FROM php:8.2-fpm

# Установка расширений
RUN docker-php-ext-install pdo pdo_mysql

# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    zip \
    libzip-dev && docker-php-ext-install zip

# Копируем проект
COPY . /var/www/html
WORKDIR /var/www/html

# Назначаем права
RUN chown -R www-data:www-data /var/www/html
