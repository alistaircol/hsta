# HSTA

Simple library management RESTful json API.

```
docker exec -it -u 1000 hsta_library bash -c "./vendor/bin/phpunit --testdox"

PHPUnit 8.5.2 by Sebastian Bergmann and contributors.

Add Book Validation (Tests\Unit\AddBookValidation)
 ✔ Isbn rule
 ✔ Iso 4217 currency rule

Add Book (Tests\Feature\AddBook)
 ✔ Add valid book will be successful
 ✔ Add invalid book with bad isbn will be unsuccessful

Get Books (Tests\Feature\GetBooks)
 ✔ Search author robin nixon returns two books
 ✔ Search author christoper negus returns one book
 ✔ List all books within linux category
 ✔ List all books within php category
 ✔ List all books by author robin nixon in category linux

Get Categories (Tests\Feature\GetCategories)
 ✔ List all categories
 ✔ List all books within linux category
 ✔ List all books within php category

Time: 587 ms, Memory: 28.00 MB

OK (12 tests, 63 assertions)
```

## Pre-requisites

Application is in a couple Docker containers.

* `hsta_library` is our web server
* `hsta_library_db` is our database which `hsta_library` is dependent on

## Installation

We have our app in mounted in `hsta_library` (web server) container.

We need to bring our container up and install `composer` dependencies.

```
docker-compose up- d
docker exec -it -u 1000 hsta_library bash -c "composer install"
```

I'm using `-u 1000` so I don't get any files on my host created with default `uid` of `0` (root).

### Database

Prepare database by creating a schema and then run Laravel migrations.

```
docker exec -i hsta_library_db mysql --user=root --password=password << "SQL"
CREATE SCHEMA IF NOT EXISTS `library`;
SQL

docker exec -it -u 1000 hsta_library bash -c "php artisan migrate:refresh --seed"
```

## Development

XDebug is installed in the container, so you should edit `.containers/php/config/php/xdebug.ini` and update the `xdebug.remote_host` to your host machine IP address.

Any new utilities to install in the container, to rebuild the container:

```
docker-compose down
docker-compose up -d --build hsta_library
```

What queries is our app doing?

```
# watch query logs
docker exec -it hsta_library_db bash -c "tail -fn10 /var/log/mysql/mysql.log"

# watch error logs
docker exec -it hsta_library_db bash -c "tail -fn10 /var/log/mysql/error.log"

# watch slow logs
docker exec -it hsta_library_db bash -c "tail -fn10 /var/log/mysql/slow.log"
```

### Logging

Laravel can be configured to go to `stdout`, you can see them with `docker-compose logs` command.

This app doesn't do much logging currently.

## Testing

```
docker exec -it -u 1000 hsta_library bash -c "./vendor/bin/phpunit"
# pretty output
docker exec -it -u 1000 hsta_library bash -c "./vendor/bin/phpunit --testdox"
```

## Design Choices

* Using Single action controllers for keeping controllers slim, delegating validation to the incoming requests
* Using `nicebooks/isbn` within a custom ISBN validation rule
* Using `symfony/intl` for ISO 4217 currency code data within a custom currency code validation rule
