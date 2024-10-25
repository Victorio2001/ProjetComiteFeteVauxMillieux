FROM php:8.3-fpm

LABEL fr.asso.ort.lyon.author="Billy Villena <billy.villena@lyon.ort.asso.fr>"
LABEL fr.asso.ort.lyon.usage="Cours « Framework - Symfony » "
LABEL fr.asso.ort.lyon.updated_at="2024-04-04T02:35:16.068+02:00"

COPY --from=composer:2.7 /usr/bin/composer /usr/local/bin/composer

# Install system dependencies
RUN apt-get update -y \
    && apt-get install -y --no-install-recommends \
        bash \
        curl \
        git \
        htop \
        libicu-dev \
        libjudy-dev \
        libpng-dev \
        libpq-dev \
        libzip-dev \
        procps \
        unzip \
        wget \
        zip
RUN \
    docker-php-ext-install \
		intl \
		opcache \
        pdo \
        pdo_pgsql \
		zip \
	&& pecl install \
        apcu  \
        xdebug \
	&& docker-php-ext-enable \
        apcu \
        xdebug

###> recipes ###
###< recipes ###

COPY --link ./conf/*.ini $PHP_INI_DIR/conf.d/

WORKDIR /usr/app

# Define user to prevent root-user; set host current user gid and uid to bind both users for better permissions
RUN addgroup --gid 1001 app \
    && adduser --disabled-password --uid 1001 --ingroup app app \
    && chown -R app /usr/app

USER app

ENTRYPOINT ["php-fpm", "-F"]
