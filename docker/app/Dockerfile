FROM php:8.0-apache

# 設定ファイルをdockerコンテナ内のPHP、Apacheに読み込ませる
ADD php.ini /usr/local/etc/php/
ADD 000-default.conf /etc/apache2/sites-enabled/

# Composerのインストール
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer

# ミドルウェアインストール
RUN apt-get -y update \
    && apt-get install -y \
    curl\
    git \
    zip \
    unzip \
    vim \
    gnupg\
    libpng-dev \
    libpq-dev \
    && docker-php-ext-install pdo_mysql

# Laravelで必要になるmodRewriteを有効化する
RUN mv /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled
RUN /bin/sh -c a2enmod rewrite

# npmの導入
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs
RUN npm install npm@latest -g

WORKDIR /