FROM ubuntu:xenial

ENV OS_LOCALE="en_US.UTF-8"
RUN apt-get update && apt-get install -y locales && locale-gen ${OS_LOCALE}
ENV LANG=${OS_LOCALE} \
    LANGUAGE=${OS_LOCALE} \
    LC_ALL=${OS_LOCALE} \
    DEBIAN_FRONTEND=noninteractive

ENV APPLICATION_ENV=dev

ENV PHP_CONF_DIR=/etc/php/7.2 \
    PHP_DATA_DIR=/var/lib/php

RUN	\
	BUILD_DEPS='software-properties-common python-software-properties' \
    && dpkg-reconfigure locales \
	&& apt-get install --no-install-recommends -y $BUILD_DEPS \
	&& add-apt-repository -y ppa:ondrej/php \
	&& apt-get update \
    && apt-get install -y git-core \
	&& apt-get install -y imagemagick \
    && apt-get install -y curl \
        php7.2-cli \
        php7.2-readline \
        php7.2-mbstring \
        php7.2-intl \
        php7.2-zip \
        php7.2-xml \
        php7.2-json \
        php7.2-curl \
        php7.2-gd \
        php7.2-pgsql \
        php7.2-mysql \
        php7.2-apc \
        php7.2-gd \
        php7.2-imagick \
        php-pear \
        php-dev \
        libmcrypt-dev \
    # Make php 7.2 default cli php
    && ln -sf /usr/bin/php7.2 /usr/bin/php \
    # Apache settings
    # PHP settings
	&& phpenmod mcrypt \
	# Install composer
	&& curl -sS https://getcomposer.org/installer | php -- --version=1.6.4 --install-dir=/usr/local/bin --filename=composer \
	# Cleaning
	&& apt-get purge -y --auto-remove $BUILD_DEPS \
	&& apt-get autoremove -y \
	&& rm -rf /var/lib/apt/lists/*
	# Forward request and error logs to docker log collector

WORKDIR /var/www/app/

COPY . /var/www/app/

EXPOSE 80 443
