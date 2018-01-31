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
php bin/console doctrine:schema:update --force
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:update --force --env=test

```

4. To load initial data execute fixture command:

```
php bin/console doctrine:fixtures:load
```

5. From application root, run server:

```
php bin/console server:run
```

6. Test this route to see the list of Albums (you can also delete album form delete link):

```
http://127.0.0.1:8000/
```

7. Test this route to see add an Album:

```
http://127.0.0.1:8000/add-album
```


## Running the tests

From application root, execute tests with this command: ./vendor/bin/simple-phpunit .


