FROM php:8.1-apache

# Sistem paketlerini güncelle ve gerekli kütüphaneleri kur
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    mysql-client \
    git \
    curl \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# PHP Modüllerini yükle
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql

# Composer'ı yükle
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Apache modülleri etkinleştir
RUN a2enmod rewrite

# Çalışma dizinini ayarla
WORKDIR /var/www/html

# Public klasörünü DocumentRoot olarak ayarla
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Bağlantı noktasını aç
EXPOSE 80

CMD ["apache2-foreground"]
