FROM php:7.4-apache

ENV ZENCART_FN=zen-cart-v1.5.7c-03052021

RUN apt-get update && apt-get install -y \
       curl \
	   wget \
       unzip \
       apt-utils \
       zlib1g-dev \
       libpng-dev \
       libmcrypt-dev \
       libzip-dev \
       zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-source extract \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install gd \
    && docker-php-ext-install opcache
RUN a2enmod rewrite

ADD https://nchc.dl.sourceforge.net/project/zencart/CURRENT%20-%20Zen%20Cart%201.5.x%20Series/${ZENCART_FN}.zip /tmp/${ZENCART_FN}.zip

WORKDIR /tmp
RUN unzip -q ${ZENCART_FN}.zip \
    && rm -f ${ZENCART_FN}.zip \
    && rm -rf /var/www/html \
    && mv ${ZENCART_FN} /var/www/html \
    && cd /var/www/html \
    && cp includes/dist-configure.php includes/configure.php \
    && cp admin/includes/dist-configure.php admin/includes/configure.php \
    && chown -R www-data:www-data /var/www/html

RUN echo '[Date]' > /usr/local/etc/php/conf.d/timezone.ini \
 && echo 'date.timezone = "Asia/Tokyo"' >> /usr/local/etc/php/conf.d/timezone.ini

WORKDIR /var/www/html

CMD ["apache2-foreground"]
