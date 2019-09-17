# Laravel API Microservice #

RESTful API as Microservice created with Laravel framework.

## Dependencies ##

- PHP 7.1.3
- PHP extensions: ext-json, ext-mbstring, ext-openssl, ext-mailparse

## Setup project on Localhost ##

### 1. Add url to Hosts file ###

Add the following lines to your hosts file:

    127.0.0.1    www.demo.local
    127.0.0.1    demo.local

### 2. Create environment file ###

Copy source of `.env.example` to newly created `.env` file. Prepare app and database configuration settings.

Also, create additional `.env.testing` file for running PHPUnit tests or used while running Artisan commands with the `--env=testing` option.

### 3. Run following commands ###

Run the following commands in terminal:

    composer update
    php artisan config:cache
    php artisan route:cache

### 4. Create database ###

Create `demo_db` database locally. Charset must be set to `utf8mb4` and collation to `utf8mb4_unicode_ci`.

### 5. Run database migrations and seeders ###

Run the following command to start migrations:

    php artisan doctrine:migrations:migrate
    
Or to refresh entire database:
    
    php artisan doctrine:migrations:refresh
    
And run the following command to start data seeders:

    php artisan db:seed
    
### 6. Run Unit tests ###

For running PHP Feature and PHP Unit tests run the following command:

    ./vendor/bin/phpunit
