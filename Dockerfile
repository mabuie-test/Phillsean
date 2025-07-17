# Usa a imagem oficial PHP com CLI e Apache
FROM php:8.1-apache

# Instala extensões necessárias
RUN apt-get update && \
    apt-get install -y libssl-dev && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Copia o código da aplicação
WORKDIR /var/www/html
COPY . /var/www/html

# Instala dependências PHP via Composer
RUN composer install --no-dev --optimize-autoloader

# Exponha a porta padrão do Apache
EXPOSE 80

# Certifique-se de que o Apache serve o index.php
CMD ["apache2-foreground"]
