FROM php:8.1-apache

# Instala dependências de compilação
RUN apt-get update && \
    apt-get install -y \
      libssl-dev \
      libsasl2-dev \
      zlib1g-dev \
      libcurl4-openssl-dev \
      pkg-config \
      make \
      autoconf \
      g++

# Instala versão 1.20.0 da extensão C do MongoDB (compatível com mongodb/mongodb:^1.20)
RUN pecl install mongodb-1.20.0 && \
    docker-php-ext-enable mongodb

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /var/www/html
COPY . /var/www/html

# Instala dependências PHP via Composer
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80
CMD ["apache2-foreground"]
