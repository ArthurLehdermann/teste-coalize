 # Alpine 3.7 has PHP 7.1.33 available
FROM alpine:3.7

RUN apk update && apk upgrade

# Install bash, nginx, supervisor, vim and curl
RUN apk --update add --no-cache bash nginx supervisor vim curl

# Install PHP 7.1 and some extensions
RUN apk --update add --no-cache php7 php7-dom php7-fpm php7-curl php7-xml php7-mbstring php7-mcrypt php7-opcache php7-pdo php7-pdo_mysql \
    php7-mysqli php7-tokenizer php7-fileinfo php7-openssl php7-json php7-session php7-gd php7-imagick php7-zip php7-phar

# Clear cache
RUN rm -Rf /var/cache/apk/*

# Install composer v1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Copy some configuration files
COPY conf/nginx/nginx.conf /etc/nginx/nginx.conf
COPY conf/nginx/supervisord.conf /etc/supervisord.conf

# Create the working directory
RUN mkdir -p /app
RUN chmod -R 755 /app
WORKDIR /app

EXPOSE 80 80

CMD ["supervisord", "-c", "/etc/supervisord.conf"]

# Based on: http://petronetto.com.br/2017/05/08/criando-uma-aplicacao-laravel-com-docker