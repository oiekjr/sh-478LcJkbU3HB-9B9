FROM php:8.4-fpm AS base

# 依存パッケージのインストール
RUN apt-get update \
    && apt-get install -y \
      libpng-dev \
      libonig-dev \
      libxml2-dev \
      zip \
      unzip \
      git \
      curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composerのインストール
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD ["php-fpm"]

# TODO: production build
