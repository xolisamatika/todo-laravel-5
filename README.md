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

Install the project dependecies (Bower)

```
bower install
```

Install the project dependecies (Composer)

```
composer install
```

### Get it running

To get it running, simply navigate to the public folder and hit up temp web server on any port of your choosing

```
php -S localhost:8008
```

Now in your browser go to : http://localhost:8008/todos