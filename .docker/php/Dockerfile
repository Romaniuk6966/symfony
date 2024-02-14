FROM php:8.2-fpm

RUN apt-get update && \
    apt-get install -y \
    g++ \
    git \
    zip \
    libpq-dev \
    zlib1g-dev \
    libicu-dev \
    libzip-dev \
    redis-server && \
    docker-php-ext-install intl \
    pdo \
    opcache \
    pdo_pgsql && \
    pecl install apcu redis && \
    docker-php-ext-enable apcu redis && \
    docker-php-ext-configure zip && \
    docker-php-ext-install zip

COPY .docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY .docker/php/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www/app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
#RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
