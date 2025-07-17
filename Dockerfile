FROM php:8.1-apache

# 1) Instala pacotes de sistema e certificados
RUN apt-get update && \
    apt-get install -y \
      git \
      curl \
      zip \
      libzip-dev \
      libssl-dev \
      libsasl2-dev \
      zlib1g-dev \
      libcurl4-openssl-dev \
      pkg-config \
      make \
      autoconf \
      g++ \
      ca-certificates && \
    update-ca-certificates && \
    rm -rf /var/lib/apt/lists/*

# 2) Instalação de extensões PHP necessárias
#    - mongodb (driver C), zip, mbstring, opcache
RUN pecl install mongodb-1.20.0 && \
    docker-php-ext-enable mongodb && \
    docker-php-ext-install zip mbstring && \
    docker-php-ext-enable opcache

# 3) Composer (permitir rodar como root)
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/bin --filename=composer

# 4) Copia projeto
WORKDIR /var/www/html
COPY . /var/www/html

# 5) Instala dependências PHP definidas no composer.json
RUN composer install --no-dev --optimize-autoloader

# 6) Habilita mod_rewrite (se precisar de URLs amigáveis)
RUN a2enmod rewrite

# 7) Ajusta permissões (se necessário para uploads/geração de arquivos)
RUN chown -R www-data:www-data /var/www/html/invoices

# 8) Exponha a porta 80 e inicie o Apache
EXPOSE 80
CMD ["apache2-foreground"]
