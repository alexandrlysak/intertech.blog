FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        zlib1g-dev \
        libicu-dev \
        g++ \
        libxml2-dev \
        libxslt1.1 \
        libxslt1-dev \
        libmemcached-dev \
        cron \
        libmagickwand-dev --no-install-recommends \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) intl xsl iconv mcrypt mbstring mysqli pdo_mysql zip soap bcmath \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-source extract \
    && git clone --branch php7 https://github.com/php-memcached-dev/php-memcached /usr/src/php/ext/memcached/ \
    && docker-php-ext-install memcached \
    && docker-php-source delete

RUN apt-get install -y locales \
    && locale-gen ru_RU.UTF-8 \
    && locale-gen uk_UA.UTF-8 \
    && update-locale

RUN sed -i -e 's/# ru_RU.UTF-8 UTF-8/ru_RU.UTF-8 UTF-8/' /etc/locale.gen && \
    sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen && \
    sed -i -e 's/# uk_UA.UTF-8 UTF-8/uk_UA.UTF-8 UTF-8/' /etc/locale.gen && \
    locale-gen && \
    update-locale LANG=ru_RU.UTF-8 && \
    echo "LANGUAGE=ru_RU.UTF-8" >> /etc/default/locale && \
    echo "LC_ALL=ru_RU.UTF-8" >> /etc/default/locale

RUN apt-get install -y jpegoptim
RUN apt-get install -y optipng

COPY ./image_optimization.sh /usr/local/bin/image_optimization
RUN chmod +x /usr/local/bin/image_optimization

RUN ln -sf /usr/share/zoneinfo/Europe/Kiev /etc/localtime
RUN echo Europe/Kiev > /etc/timezone

RUN apt-get purge --auto-remove -y g++ \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

CMD ["php-fpm"]