FROM php:8.1-apache

# Instala dependências de compilação + git
RUN apt-get update && \
    apt-get install -y \
      git \
      libssl-dev \
      libsasl2-dev \
      zlib1g-dev \
      libcurl4-openssl-dev \
      pkg-config \
      make \
      autoconf \
      g++
      ca-certificates && \
     update-ca-certificates

# Instala versão 1.20.0 da extensão C do MongoDB (compatível com mongodb/mongodb:^1.20)
RUN pecl install mongodb-1.20.0 && \
    docker-php-ext-enable mongodb

# Permite rodar Composer como root e instala o Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Define diretório de trabalho e copia a aplicação
WORKDIR /var/www/html
COPY . /var/www/html

# Instala dependências PHP via Composer
RUN composer install --no-dev --optimize-autoloader

# Expõe a porta 80 e inicia o Apache
EXPOSE 80
CMD ["apache2-foreground"]
