FROM php:8.3-fpm

ARG UID=1000
ARG GID=1000

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libonig-dev \
    libxml2-dev \
    libxslt1-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install \
        intl \
        pdo_mysql \
        zip \
        gd \
        mbstring \
        opcache \
        ctype \
        iconv \
        xml \
        xsl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN groupadd -g ${GID} symfony \
    && useradd -u ${UID} -g symfony -m symfony

COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini

WORKDIR /var/www/html

USER symfony
