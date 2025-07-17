FROM php:8.1-apache

# 1. Instala dependências de compilação + git
RUN apt-get update && \
    apt-get install -y \
      git \                     # ← adiciona o Git
      libssl-dev \
      libsasl2-dev \
      zlib1g-dev \
      libcurl4-openssl-dev \
      pkg-config \
      make \
      autoconf \
      g++

# 2. Instala versão 1.20.0 da extensão MongoDB via PECL
RUN pecl install mongodb-1.20.0 && \
    docker-php-ext-enable mongodb

# 3. Instala o Composer e permite rodar como root
ENV COMPOSER_ALLOW_SUPERUSER=1      # ← permite execução como root
RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=/usr/bin --filename=composer

WORKDIR /var/www/html

# 4. Copia o código da aplicação
COPY . /var/www/html

# 5. Instala dependências PHP via Composer (agora com git disponível)
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80
CMD ["apache2-foreground"]
