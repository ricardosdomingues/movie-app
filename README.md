# Movie App

Application that allows a user to store the movies that he has watched in the past and/or the movies that he would like to watch in the future.

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository

    git clone https://github.com/ricardosdomingues/movie-app.git

Switch to the repo folder

    cd movie-app

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations/seeders (**Set the database connection in .env before migrating**)

    php artisan migrate:fresh --seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/ricardosdomingues/movie-app.git
    cd movie-app
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate:fresh --seed
    php artisan serve
    
Demo Account

    Email: demo@mail.com
    password: 123456789

Observation: If you happen to run the tests you will need to run the seeders again because the database gets cleared up after each test

## Tests
    ./vendor/bin/phpunit
