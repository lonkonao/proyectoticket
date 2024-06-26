FROM phpdockerio/php74-fpm:latest

COPY . /application

WORKDIR /application
# Fix debconf warnings upon build

ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.4-mysql \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Copy SQL script and entrypoint script
COPY init.sql /docker-entrypoint-initdb.d/

EXPOSE 8080
