FROM php:8.2-cli-alpine

RUN apk add --no-cache git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY composer.json /app/

RUN composer install

COPY . /app/


# Command to run when the container starts
CMD ["php", "src/PayDatesCommand.php"]