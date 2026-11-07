# syntax=docker/dockerfile:1
FROM php:8.5.12-apache

# The optional CA mount supports builds behind a trusted HTTPS proxy.
# Ordinary builds on Ubuntu do not need this secret.
RUN --mount=type=secret,id=proxy_ca \
    set -eux; \
    if [ -f /run/secrets/proxy_ca ]; then \
        export CURL_CA_BUNDLE=/run/secrets/proxy_ca; \
    fi; \
    apt-get update; \
    apt-get install -y --no-install-recommends libpq-dev; \
    docker-php-ext-install -j"$(nproc)" pdo_mysql pdo_pgsql; \
    curl --fail --silent --show-error --location \
        https://pecl.php.net/get/redis-6.3.0.tgz --output /tmp/redis.tgz; \
    pecl install /tmp/redis.tgz; \
    docker-php-ext-enable redis; \
    rm -rf /var/lib/apt/lists/* /tmp/pear /tmp/redis.tgz

WORKDIR /var/www/html
