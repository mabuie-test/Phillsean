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

# 2) Instala extensões PHP com driver MongoDB 1.21.0, zip, mbstring e opcache
RUN pecl install mongodb-1.21.0 && \
    docker-php-ext-enable mongodb && \
    docker-php-ext-install zip mbstring && \
    docker-php-ext-enable opcache

# 3) Instala o Composer como root
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/bin --filename=composer

# 4) Copia o código-fonte e instala dependências PHP
WORKDIR /var/www/html
COPY . /var/www/html
RUN composer install --no-dev --optimize-autoloader

# 4.1) Executa o script de correção de "details"
# (se houver erros, seguimos em frente graças ao "|| true")
RUN php fix_details.php || true

# 5) Habilita mod_rewrite (caso use .htaccess)
RUN a2enmod rewrite

# 6) Prepara diretório de faturas com permissões
RUN mkdir -p invoices && chown -R www-data:www-data invoices

# 7) Exponha a porta e inicialize o Apache
EXPOSE 80
CMD ["apache2-foreground"]
