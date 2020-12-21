FROM php:7.4-fpm-alpine

# Install basic dependencies
RUN apk update && \
    apk -u add bash git \ 
  && apk add bzip2 file re2c freetds freetype icu libintl libldap libjpeg libmcrypt libpng \
    libpq libwebp libzip nodejs npm \
    autoconf \ 
    bzip2-dev \
    freetds-dev \
    freetype-dev \
    g++ \
    gcc \
    gettext-dev \
    icu-dev \
    jpeg-dev \
    libmcrypt-dev \
    libwebp-dev \
    libxml2-dev \
    libzip-dev \
    make \
    openldap-dev \
    postgresql-dev \
    curl
    
RUN docker-php-ext-configure pdo_dblib --with-libdir=lib/ \
 && docker-php-ext-install \
      bz2 \
      exif \
      gd \
      gettext \
      intl \
      ldap \
      pdo_dblib \
      pdo_pgsql \
      xmlrpc \
      zip

WORKDIR /var/www/app

# Install PHPUnit
RUN curl -sSL -o /usr/bin/phpunit https://phar.phpunit.de/phpunit.phar && chmod +x /usr/bin/phpunit

# Expose ports and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
