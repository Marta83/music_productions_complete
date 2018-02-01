# Project Title

Music production management

## Getting Started

These instructions will get you a copy of the Symfony 3 project up and running on your local machine for development and testing purposes.

### Prerequisites

For the correct execution of the application PHP 7.1 is needed and php7.1-sqlite3


```
sudo apt-get install php7.0 php7.0-fpm php7.0-mysql -y
```
```
sudo apt install php7.1-sqlite3
```

### Installing

1. Download project

2. From application root execute composer install and enter parameter.yml data when the installer required them. (Database host and name for dev and test enviroments).

3. Execute this commands in order to create database for dev and test enviroment:

```
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:update --force --env=test

```

4. Load initial data from fixtures:

```
php bin/console doctrine:fixtures:load
```

5. From application root, run server:

```
php bin/console server:run
```

6. Test this route to see the list of Albums:

```
http://127.0.0.1:8000/
```
In this page you can manage the productions of the company. This is the list of actions you can do and How

- Add a new Album: Click the link "Add album" and you will be redirected to add album form.

- Delete album : In the corresponding album line click the link "Delete" and album will be deleted.

- Add a artist to existed album : In the corresponding album line click the link "Add artist" and you will redirect to a form to insert artist information.

- Delete artist: Each album has it's own artist list. Each artist has a delete link. If delete link is clicked the association between album and artist is going to be remove and if the artist doesn't have mor associations the artist also will be remove.


## Running the tests

From application root, execute tests with this command: ./vendor/bin/simple-phpunit .


