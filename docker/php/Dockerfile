FROM node:16 AS node
FROM php:8.0-fpm
WORKDIR "/app"

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

# Update packages & Install Git, Supervisor and image libs
RUN apt-get update -y && \
    apt-get install -yq git supervisor cron nano unzip zip zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev

# Install GD extension and configure php ext
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j "$(nproc)" gd
RUN docker-php-ext-install mbstring exif pcntl bcmath

# Install Swoole & inotify extension
RUN pecl install swoole inotify
RUN docker-php-ext-enable swoole
RUN docker-php-ext-enable inotify

# MySQL Support
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install xDebug
RUN pecl install pcov
RUN docker-php-ext-enable pcov

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy crontab file to the cron.d directory
COPY ./crontab /etc/crontabs/root

# Give execution rights on the cron job
RUN chmod 0644 /etc/crontabs/root

# Apply cron job
RUN crontab /etc/crontabs/root

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

# Added supervisor config
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisor.conf

CMD ["/usr/bin/supervisord", "-n"]
