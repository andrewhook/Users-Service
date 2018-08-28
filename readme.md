# Users Service

## Architecture
The service consists of three containers each with its own responsibility. One is responsible for serving the application, another for providing the database and finally a web server to proxy traffic to the application.

The Lumen framework is used to form the web application which gives us routing, models, controllers and much more. Tests are written as per the built-in test framework.

## Set up guide
### Create configuration file
`cp .env.example .env`

### Installing dependencies
`docker run --rm --interactive --tty --volume $(pwd):/app composer install`

### Running tests
`docker-compose exec app ./vendor/bin/phpunit`

## Useful commands
`docker-compose exec app php artisan migrate --seed`
`docker-compose up`
`docker-compose up -d`
`docker-compose build`
`docker-compose down`

`docker run --rm --interactive --tty --volume $(pwd):/app composer create-project --prefer-dist laravel/lumen new-lumen-project`

`docker-compose exec app php artisan make:migration create_users_table --create=users`
