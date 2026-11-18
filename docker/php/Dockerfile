FROM php:8.4-fpm

ARG INSTALL_XDEBUG=false

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) \
    pdo_pgsql \
    pcntl \
    bcmath \
    opcache \
    zip

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN if [ "$INSTALL_XDEBUG" = "true" ]; then \
    pecl install xdebug \
    && docker-php-ext-enable xdebug; \
fi

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
