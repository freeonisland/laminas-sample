FROM php:7.4-fpm
#debian buster 10.3

#####################
# memory
# - check VirtualBox memory
# - docker builder prune
# - docker volumes
#####################

# apt-get
RUN apt-get update && ENV_DOCKER_UNIQ_TOKEN=8b6fh817b86761dg681d
RUN apt-get install -y sqlite3 wget zip 

# php ext: ldap...
RUN apt-get install -y libldap2-dev
RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ 
RUN docker-php-ext-install ldap 

# for laminas form view helper
RUN apt-get install icu-devtools libicu-dev
RUN docker-php-ext-configure intl && docker-php-ext-install intl

# composer
#RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN wget https://getcomposer.org/installer && php ./installer
RUN mv ./composer.phar /usr/local/bin/composer 

# Enable SSH
RUN apt-get install -y sshpass openssh-server && systemctl enable ssh
RUN ssh-keygen -t rsa -f /root/.ssh/id_rsa -P ''

# Access ssh with www-data
RUN cp -r /root/.ssh /var/www 
RUN chown www-data:www-data /var/www/.ssh && chown www-data:www-data /var/www/.ssh/*

# Load SSH in docker-entrypoint
RUN echo 'root' > /pass
RUN echo "#!/bin/bash\n" > /usr/local/bin/docker-entrypoint.sh
RUN echo "ssh-keyscan -H ldap-server >> /root/.ssh/known_hosts\n" >> /usr/local/bin/docker-entrypoint.sh
RUN echo "sshpass -v -f /pass ssh-copy-id -i /root/.ssh/id_rsa ldap-server\n" >> /usr/local/bin/docker-entrypoint.sh
RUN echo "php-fpm" >> /usr/local/bin/docker-entrypoint.sh
RUN chmod 777 /usr/local/bin/docker-entrypoint.sh

# -PECL ALREADY INSTALLED- wget http://pear.php.net/go-pear.phar && pecl channel-update pecl.php.net && php go-pear.phar
# RUN apt-get install -y php-pecl && pecl update  && pecl install xdebug

# zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20190902/xdebug.so" to php.ini
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > $PHP_INI_DIR/conf.d/xdebug.ini
    # && echo "xdebug.remote_enable=On" >> $PHP_INI_DIR/conf.d/xdebug.ini \
    # && echo "xdebug.remote_autostart=On" >> $PHP_INI_DIR/conf.d/xdebug.ini \
    # && echo "xdebug.remote_connect_back=On" >> $PHP_INI_DIR/conf.d/xdebug.ini \
    # && echo "xdebug.idekey=PHPSTORM" >> $PHP_INI_DIR/conf.d/xdebug.ini

# clean apt
RUN rm -rf /var/lib/apt/lists/*
 
# -backwards compat
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]