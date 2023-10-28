#!/bin/bash

# Wait for the database to become available
/wait-for-it.sh db:3306 -t 60
rm -rf vendor composer.lock
composer install

# Run database migrations
php artisan migrate:refresh --seed

php artisan key:generate

# Start your application
php artisan serve --host=0.0.0.0