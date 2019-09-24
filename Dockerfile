FROM php:7.3-fpm

# Set working directory
WORKDIR /var/www

# Install packages
RUN apt-get update && apt-get install -y \
    cron \
    curl \
    git \
    libpq-dev \
    locales \
    nginx \
    tzdata \
    unzip \
    zip

# Set locale
# RUN locale-gen en_US en_US.UTF-8 pt_BR pt_BR.UTF-8
# RUN dpkg-reconfigure locales

# Set timezone
ENV TZ America/Sao_Paulo
RUN echo $TZ > /etc/timezone \
    rm /etc/localtime && \
    ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && \
    dpkg-reconfigure -f noninteractive tzdata

# Install extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    bcmath

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install composer dependencies
COPY composer.json ./
COPY composer.lock ./

RUN composer install --no-interaction --no-scripts --no-autoloader

# Copy app source code
COPY . .

# Copy nginx and php config files
COPY ./deploy/nginx.conf /etc/nginx/conf.d/nginx.conf
COPY ./deploy/php.ini /usr/local/etc/php/conf.d/php.ini

RUN rm -rf /etc/nginx/sites-enabled
RUN mkdir -p /etc/nginx/sites-enabled

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Update permissions
RUN chmod 777 ./start
RUN chmod -R 777 ./storage

# Autoload
RUN composer dump-autoload --optimize

# Cron setup
COPY ./deploy/cron /etc/cron.d/schedule-cron
RUN chmod 0644 /etc/cron.d/schedule-cron
RUN crontab /etc/cron.d/schedule-cron

# Start application
CMD ["./start"]

# Expose port
EXPOSE 80
