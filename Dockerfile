FROM ambientum/php:7.3-nginx

# Install composer dependencies
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-autoloader

# Copy app source code
COPY . /var/www/app

# Copy config files
# COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker/nginx/laravel.conf /etc/nginx/sites/enabled.conf

# Remove nginx default
RUN sudo rm -rf /etc/nginx/sites-enabled
RUN sudo mkdir -p /etc/nginx/sites-enabled

# Update permissions
RUN sudo chmod -R 777 /var/www/app/storage
RUN sudo chmod -R 777 /var/www/app/bootstrap/cache
RUN sudo chmod +x /var/www/app/docker/sh/start

# Autoload
RUN composer dump-autoload --optimize

# Expose port
EXPOSE 8080

# Start application
CMD ["/var/www/app/docker/sh/start"]
