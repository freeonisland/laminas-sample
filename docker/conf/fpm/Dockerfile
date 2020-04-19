FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y libldap2-dev wget sshpass git zip && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure ldap  --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install ldap 

RUN apt-get update && apt-get install -y openssh-server && systemctl enable ssh && echo 'root' > /pass

#access ssh with www-data
RUN ssh-keygen -t rsa -f /root/.ssh/id_rsa -P '' && cp -r /root/.ssh /var/www 
RUN chown www-data:www-data /var/www/.ssh && chown www-data:www-data /var/www/.ssh/*

RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
RUN mv ./composer.phar /usr/local/bin/composer 

RUN echo "#!/bin/bash\n" > /usr/local/bin/docker-entrypoint.sh
RUN echo "ssh-keyscan -H ldap-server >> /root/.ssh/known_hosts\n" >> /usr/local/bin/docker-entrypoint.sh
RUN echo "sshpass -v -f /pass ssh-copy-id -i /root/.ssh/id_rsa ldap-server\n" >> /usr/local/bin/docker-entrypoint.sh
RUN echo "php-fpm" >> /usr/local/bin/docker-entrypoint.sh
RUN chmod 777 /usr/local/bin/docker-entrypoint.sh
 
# backwards compat
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

