FROM php:8.1-apache

# 1) Instala pacotes de sistema e certificados (inclui libonig-dev)
RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
      git curl zip libzip-dev libonig-dev \
      libssl-dev libsasl2-dev zlib1g-dev \
      libcurl4-openssl-dev pkg-config \
      make autoconf g++ ca-certificates && \
    update-ca-certificates && \
    rm -rf /var/lib/apt/lists/*

# 2) Instala extensões PHP com driver MongoDB 1.21.0
RUN pecl install mongodb-1.21.0 && \
    docker-php-ext-enable mongodb && \
    docker-php-ext-install zip mbstring && \
    docker-php-ext-enable opcache

# 3) Composer (permitir rodar como root)
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/bin --filename=composer

# 4) Copia código e instala dependências PHP
WORKDIR /var/www/html
COPY . /var/www/html
RUN composer install --no-dev --optimize-autoloader

# 5) Habilita mod_rewrite (se usar .htaccess)
RUN a2enmod rewrite

# 6) Prepara diretório de faturas
RUN mkdir -p invoices && chown -R www-data:www-data invoices

# 7) Exponha e rode
EXPOSE 80
CMD ["apache2-foreground"]
