FROM dunglas/frankenphp:php8.3

RUN install-php-extensions \
    pdo_pgsql \
    pgsql

WORKDIR /app

COPY . /app

ENV SERVER_NAME=:${PORT}

CMD ["frankenphp", "run", "--config", "/etc/frankenphp/Caddyfile"]