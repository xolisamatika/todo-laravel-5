# todo-laravel-5

This is a simple Todo App build with laravel 5, using Mysql for database.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

Things you need to install and run the app.

* PHP 7.2
* MySQL 5.5
* Laravel Framework 5.6.3
* Bower 1.8.2
* Composer 1.4.1

### Installing

A step by step series of examples that tell you have to get a development env running

Clone this repo

```
git clone https://github.com/xolisamatika/todo-laravel-5
```

Enter the project folder and run the sql script to the install database. PS: replace the username and password if yours differ.

```
cd todo-laravel-5/ && mysql -uroot -proot < ./todoDb.sql
```

Install the project dependecies (Composer)

```
composer install
```
Create your .env file from the .env.example file

```
cp .env.example .env
```

Make the following changes on the .env file (I'm using root for username and password, yours could be different).

```
DB_DATABASE=todoDb
DB_USERNAME=root
DB_PASSWORD=root
```

Generate your application encryption key

```
php artisan key:generate
```

### Get it running

To get it running, simply run the command below.

```
php artisan serve
```

Now in your browser go to : http://localhost:8000/todos