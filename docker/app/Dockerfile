FROM ubuntu:20.04

LABEL maintainer="Eduardo Iriarte-Mendez"

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

RUN apt-get update \
    && apt-get install -y gnupg ca-certificates wget zip unzip git \
    	build-essential supervisor sqlite3 curl ruby libc-dev autoconf \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu focal main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
    && apt-get update \
    && apt-get install -y nginx graphviz cron php8.0-fpm php8.0-cli \
       php8.0-pgsql php8.0-sqlite3 php8.0-gd php8.0-curl \
       php8.0-imap php8.0-mbstring \
       php8.0-xml php8.0-zip php8.0-bcmath php8.0-soap \
       php8.0-intl php8.0-readline php-msgpack php-igbinary php8.0-imagick \
       php8.0-dev php8.0-yaml \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && mkdir -p /run/php \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && echo "daemon off;" >> /etc/nginx/nginx.conf \
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log \
    && sed -i 's/^;daemonize.*$/daemonize = no/g' /etc/php/8.0/fpm/php-fpm.conf \
    && sed -i 's@^error_log.*$@error_log = /proc/self/fd/2@g' /etc/php/8.0/fpm/php-fpm.conf

RUN apt-get update \
    && apt-get install -y librdkafka-dev \
    && git clone https://github.com/arnaud-lb/php-rdkafka.git \
    && cd php-rdkafka \
    && phpize \
    && ./configure \
    && make all -j 5 \
    && make install && \
    { \
        echo '' ; \
        echo '[rdkafka]' ; \
        echo 'extension=/php-rdkafka/modules/rdkafka.so' ; \
    } | tee -a /etc/php/8.0/fpm/php.ini /etc/php/8.0/cli/php.ini \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ADD scheduler /etc/cron.d/scheduler
RUN chmod +x /etc/cron.d/scheduler \
    && crontab /etc/cron.d/scheduler \
    && touch /var/log/cron.log

ADD nginx.conf /etc/nginx/sites-available/default
ADD supervisord.conf /etc/supervisor/conf.d/supervisord.conf
ADD start-container.sh /usr/bin/start-container
RUN chmod +x /usr/bin/start-container

RUN set -eux; \
    pecl channel-update pecl.php.net \
    && pecl install xdebug && \
    { \
		echo 'memory_limit = 500M' ; \
    	echo 'upload_max_filesize = 100M' ; \
		echo 'post_max_size = 100M' ; \
		echo 'max_input_time = 300' ; \
		echo 'max_execution_time = 300' ; \
        echo '' ; \
        echo '[xdebug]' ; \
        echo 'xdebug.remote_enable=On' ; \
        echo 'xdebug.idekey=PHPSTORM' ; \
        echo 'xdebug.remote_autostart=On' ; \
        echo 'xdebug.remote_connect_back=Off' ; \
        echo 'xdebug.remote_handler=dbgp' ; \
        echo 'xdebug.profiler_enable=On' ; \
        echo 'xdebug.profiler_output_dir=/var/www/html/xdebug_out' ; \
        echo 'xdebug.remote_port=9001' ; \
        echo 'xdebug.remote_host=10.254.254.254' ; \
        echo 'zend_extension=/usr/lib/php/20200930/xdebug.so' ; \
    } | tee -a /etc/php/8.0/fpm/php.ini && \
    { \
        echo '' ; \
        echo '[xdebug]' ; \
        echo 'xdebug.mode=coverage' ; \
        echo 'zend_extension=/usr/lib/php/20200930/xdebug.so' ; \
    } | tee -a /etc/php/8.0/cli/php.ini

ENTRYPOINT ["start-container"]
