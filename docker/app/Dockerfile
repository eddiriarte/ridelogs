FROM ubuntu:20.04

LABEL maintainer="Eduardo Iriarte-Mendez"

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

# Setup PHP, nginx and additional dependencies
RUN apt-get update \
    && apt-get install -y gnupg ca-certificates wget zip unzip git \
    	build-essential supervisor sqlite3 curl ruby libc-dev autoconf \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu focal main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys E5267A6C \
    && apt-get update \
    && apt-get install -y nginx graphviz cron php8.1-fpm php8.1-cli \
       php8.1-pgsql php8.1-sqlite3 php8.1-gd php8.1-curl \
       php8.1-imap php8.1-mbstring \
       php8.1-xml php8.1-zip php8.1-bcmath php8.1-soap \
       php8.1-intl php8.1-readline php-msgpack php-igbinary php8.1-imagick \
       php8.1-dev php8.1-yaml \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && mkdir -p /run/php \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && echo "daemon off;" >> /etc/nginx/nginx.conf \
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log \
    && sed -i 's/^;daemonize.*$/daemonize = no/g' /etc/php/8.1/fpm/php-fpm.conf \
    && sed -i 's@^error_log.*$@error_log = /proc/self/fd/2@g' /etc/php/8.1/fpm/php-fpm.conf

# Copy additional configs & binaries
COPY nginx.conf supervisord.conf start-container.sh /opt/src/
RUN cp /opt/src/nginx.conf /etc/nginx/sites-available/default \
    && cp /opt/src/supervisord.conf /etc/supervisor/conf.d/supervisord.conf \
    && cp /opt/src/start-container.sh /usr/bin/start-container \
    && chmod +x /usr/bin/start-container

# PHP Module overrides
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
        echo 'zend_extension=/usr/lib/php/20210902/xdebug.so' ; \
    } | tee -a /etc/php/8.1/fpm/php.ini && \
    { \
        echo '' ; \
        echo '[xdebug]' ; \
        echo 'xdebug.mode=coverage' ; \
        echo 'zend_extension=/usr/lib/php/20210902/xdebug.so' ; \
    } | tee -a /etc/php/8.1/cli/php.ini

ENTRYPOINT ["start-container"]
