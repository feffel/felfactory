FROM php:7.3.4-cli

RUN apt-get update \
    && apt-get -y install \
        git \
        unzip \
        wget

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

RUN wget https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar && \
 wget https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar && \
 chmod +x phpcs.phar && \
 chmod +x phpcbf.phar && \
 mv phpcs.phar  /usr/local/bin/phpcs && \
 mv phpcbf.phar /usr/local/bin/phpcbf

RUN wget https://psysh.org/psysh && \
 chmod +x psysh && \
 mv psysh /usr/local/bin/psysh

WORKDIR '/app'
