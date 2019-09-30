#FROM trafex/alpine-nginx-php7
FROM alpine:3.5

RUN apk update

RUN apk add --update \
    supervisor \
    nginx \
	curl \
	php5-cli php5-common php5-fpm php5-phar php5-pdo php5-json php5-openssl \
	php5-mysql php5-pdo_mysql php5-mcrypt php5-opcache php5-sqlite3 php5-pdo_sqlite \
	php5-ctype php5-zlib php5-curl php5-gd php5-xml php5-dom \
    xvfb ttf-freefont fontconfig dbus;

COPY laravel/nginx/supervisord.conf /etc/supervisord.conf

RUN mkdir /run/nginx

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
    chmod +x /usr/local/bin/composer;

# == SERVICES COFIGURATION == 
COPY laravel/nginx/default.conf /etc/nginx/conf.d/default.conf
RUN sed -i s/nobody/nginx/ ./etc/php5/php-fpm.conf
RUN touch /var/log/supervisord.log; chown -R nginx:nginx /var/log/supervisord.log

WORKDIR /var/www/

# APPLICATION INSTALLATION

COPY laravel/notejam .
COPY migrate.sh .
COPY run_test.sh .

RUN chmod +x migrate.sh
RUN chmod +x run_test.sh

RUN composer install
RUN chown -R nginx:nginx /var/www/

# CONTAINER STARTUP

EXPOSE 80

STOPSIGNAL SIGTERM

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]