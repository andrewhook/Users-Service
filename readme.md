# Users Service

## Architecture
The service consists of three containers, each with its own responsibility. One is responsible for serving the application, another for providing the database and finally a web server to proxy traffic to the application.

The Lumen framework is used to form the web application which gives us routing, models, controllers and much more. Functional tests are written per the built-in test framework.

## Set up guide
### Create configuration file
`cp .env.example .env`

### Installing dependencies
`docker run --rm --interactive --tty --volume $(pwd):/app composer install`

### Bring up the environment
`docker-compose up -d`

### Running tests
`docker-compose exec app ./vendor/bin/phpunit`

## Testing
### Postman
A Postman collection is included in the root of this project.

### Swagger
A swagger.json file is provided in this project and the API can be explored by visting http://localhost:8888.

## Useful commands
`./vendor/bin/openapi --output swagger.json ./app`
`docker-compose exec app php artisan migrate --seed`
`docker-compose up`
`docker-compose up -d`
`docker-compose build`
`docker-compose down`

`docker run --rm --interactive --tty --volume $(pwd):/app composer create-project --prefer-dist laravel/lumen new-lumen-project`

`docker-compose exec app php artisan make:migration create_users_table --create=users`
