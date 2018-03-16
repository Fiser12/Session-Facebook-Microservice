# Microservice Facebook Session

## Descripition

This is a microservice designed to be used in conjunction with Docker. This microservice logs in with facebook receiving a Facebook access token that must be run in the login interface. The microservice returns a valid JWT to the user. Then the user when sending requests to other microservices attaches the JWT and through a shared secret the microservices communicate with it to verify who owns the Token and obtain the user data.

You get on the server side a long term facebook access token.

## Preparation of microservice

The microservice is completely independent and is designed to be deployed via docker. But if you want you can run it by yourself in the following way:

```
composer install

openssl genrsa -out var/jwt/private.pem -aes256 -passout pass:${JWT_PASSPHRASE} 4096

openssl rsa -pubout -in var/jwt/private.pem -out /session/var/jwt/public.pem -passin pass:${JWT_PASSPHRASE}

php etc/bin/symfony-console doctrine:database:create --if-not-exists

php etc/bin/symfony-console do:mi:mi -v --no-interaction
```

## Using DockerFile

I recommend saving the microservice in a folder called Session and all Docker-related files in a folder called Docker.
Then create a DockerFile that will be in charge of preparing the environment and where the project will be stored inside, isolated from the others. The docker file would have the following instructions to run this microservice.

I also recommend that the Dockerfile at the moment of instantiating the image reconstruct the parameters.yml replacing in it all the parameters that we consider modifiable to keep the secret out of the repository. To do this we would save a version in a separate directory of parameters with keywords ready to be replaced and then the Dockerfile would replace them and replace the original parameters.yml.
```
FROM php:7.1-fpm
RUN apt-get update \
	&& apt-get install -y \
		zip \
		unzip \
		vim \
		wget \
		curl \
		git \
		mysql-client \
		moreutils \
		dnsutils \
		zlib1g-dev \
		libicu-dev \
		libmemcached-dev \
		g++ \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Madrid /etc/localtime
RUN "date"

RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql opcache intl

ADD . /session
RUN chown -R www-data:www-data /session

RUN chmod -R 777 /session

RUN composer install -d=/session --no-dev --no-interaction

CMD sed \
        -e "s/\${database_host}/${DB_HOST}/" \
        -e "s/\${database_port}/${DB_PORT}/" \
        -e "s/\${database_name}/${DB_DATABASE}/" \
        -e "s/\${database_user}/${DB_ROOT}/" \
        -e "s/\${database_password}/${MYSQL_ROOT_PASSWORD}/" \
        -e "s/\${database_server_version}/${MYSQL_DATABASE_SERVER_VERSION}/" \
        -e "s/\${mailer_transport}/${MAILER_TRANSPORT}/" \
        -e "s/\${mailer_host}/${MAILER_HOST}/" \
        -e "s/\${mailer_user}/${MAILER_USER}/" \
        -e "s/\${mailer_password}/${MAILER_PASSWORD}/" \
        -e "s/\${mail_delivery_address}/${MAILER_DELIVERY_ADDRESS}/" \
        -e "s/\${router_request_context_host}/${REQUEST_CONTEXT_HOST}/" \
        -e "s/\${router_request_context_scheme}/${REQUEST_CONTEXT_SCHEME}/" \
        -e "s/\${facebook_client_id}/${OAUTH_FACEBOOK_CLIENT_ID}/" \
        -e "s/\${facebook_client_secret}/${OAUTH_FACEBOOK_CLIENT_SECRET}/" \
        -e "s/\${secret-api}/${SECRET_KEY_API}/" \
        -e "s/\${jwt}/${JWT_PASSPHRASE}/" \
        -e "s/\${env}/prod/" \
        /session/etc/docker-resources/session-parameters.yml.dist > /session/parameters.yml  && \
        openssl genrsa -out /session/var/jwt/private.pem -aes256 -passout pass:${JWT_PASSPHRASE} 4096 && \
        openssl rsa -pubout -in /session/var/jwt/private.pem -out /session/var/jwt/public.pem -passin pass:${JWT_PASSPHRASE} && \
        php /session/etc/bin/symfony-console doctrine:database:create --if-not-exists && \
        php /session/etc/bin/symfony-console do:mi:mi -v --no-interaction --allow-no-migration && \
        php-fpm -F
```
