FROM php:7.2-fpm

RUN apt-get update -y &&\
    apt-get install --no-install-recommends --assume-yes --quiet libpng-dev libjpeg-dev ca-certificates curl git &&\
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo;\
    docker-php-ext-install pdo_mysql;\
    docker-php-ext-install gd 

RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
RUN go get github.com/mailhog/mhsendmail
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail
RUN echo 'sendmail_path = /usr/bin/mhsendmail --smtp-addr mailhog:1025' > /usr/local/etc/php/php.ini
