FROM php:7.3-fpm

# Set working directory
WORKDIR /var/www

# environment variables
ENV DEBIAN_FRONTEND noninteractive

# Install packages
RUN apt-get update && apt-get install -y --no-install-recommends \
    apt-utils \
    build-essential \
    cron \
    curl \
    g++ \
    git \
    jpegoptim optipng pngquant gifsicle \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    locales \
    nginx \
    tzdata \
    unzip \
    zip \
    zlib1g-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev

# Set locale
RUN locale-gen \
    en_US \
    en_US.UTF-8 \
    pt_BR \
    pt_BR.UTF-8

RUN dpkg-reconfigure locales

# Set timezone
ENV TZ America/Sao_Paulo
RUN echo $TZ > /etc/timezone
RUN rm /etc/localtime
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime
RUN dpkg-reconfigure -f noninteractive tzdata

# Install extensions
RUN docker-php-ext-configure gd \
    --with-gd \
    --with-freetype-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ \
    --with-png-dir=/usr/include/

RUN docker-php-ext-install \
    bcmath \
    exif  \
    gd \
    intl \
    pcntl \
    pdo_mysql \
    sockets \
    zip

RUN pecl install redis \
    && docker-php-ext-enable redis

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install composer dependencies
COPY composer.json ./
COPY composer.lock ./
COPY .composer ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-autoloader

# Copy app source code
COPY . .

# Copy config files
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/php.ini

RUN rm -rf /etc/nginx/sites-enabled
RUN mkdir -p /etc/nginx/sites-enabled

# Add user for laravel application
# RUN groupadd -g 1000 www
# RUN useradd -u 1000 -ms /bin/bash -g www www

# Update permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 777 /var/www/storage
RUN chmod -R 777 /var/www/bootstrap/cache
RUN chmod +x /var/www/docker/sh/start

# Autoload
RUN composer dump-autoload --optimize

# Cron setup
COPY ./docker/cron/schedule-cron /etc/cron.d/schedule-cron
RUN chmod 0644 /etc/cron.d/schedule-cron
RUN crontab /etc/cron.d/schedule-cron

# Expose port
EXPOSE 80

# Start application
CMD ["/var/www/docker/sh/start"]
