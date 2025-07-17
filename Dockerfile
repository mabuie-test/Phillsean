# Dockerfile
FROM php:8.1-apache

# 1. Instala dependências de sistema para compilar extensões PECL
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

# 2. Instala o driver MongoDB via PECL
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb

# 3. Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# 4. Copia o código da aplicação
WORKDIR /var/www/html
COPY . /var/www/html

# 5. Instala dependências PHP via Composer
RUN composer install --no-dev --optimize-autoloader

# 6. Exponha a porta 80 e inicie o Apache
EXPOSE 80
CMD ["apache2-foreground"]
