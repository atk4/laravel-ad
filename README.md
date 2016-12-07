# Laravel Agile Data

*A drop-in integration for Laravel 5+ to allow use of Agile Data natively.*


[![Build Status](https://travis-ci.org/atk4/laravel-ad.png?branch=develop)](https://travis-ci.org/atk4/laravel-ad)
[![Code Climate](https://codeclimate.com/github/atk4/laravel-ad/badges/gpa.svg)](https://codeclimate.com/github/atk4/laravel-ad)
[![StyleCI](https://styleci.io/repos/56442737/shield)](https://styleci.io/repos/56442737)
[![Test Coverage](https://codeclimate.com/github/atk4/laravel-ad/badges/coverage.svg)](https://codeclimate.com/github/atk4/laravel-ad/coverage)
[![codecov](https://codecov.io/gh/atk4/laravel-ad/branch/develop/graph/badge.svg)](https://codecov.io/gh/atk4/laravel-ad)
[![Version](https://badge.fury.io/gh/atk4%2Flaravel-ad.svg)](https://packagist.org/packages/atk4/laravel-ad)


## Installation

First install via composer

```php
composer require "atk4/laravel-ad"
```

Next, add the ServiceProvider to the providers array in `config/app.php`

```php
at4k\LaravelAD\AgileDataServiceProvider::class
```

Finally, publish the configuration file by running the command:

```php
php artisan vendor:publish --tag="agiledata"
```

## Configuration

Without any additional configuration LaravelAD will use the default connection specified in your `config/database.php` configuration.

To use a different connection simply specify the connection name in `config/agiledata.php`.

## Usage

There are two ways to get an instance of `atk4\data\Persistence` which follow the normal behavior of [resolving](https://laravel.com/docs/5.1/container#resolving) a dependency in Laravel.

Through a type-hint in any class that is resolved through the service container:

```php
use Illuminate\Routing\Controller;

class MyController extends Controller 
{
    public function __construct(atk4\data\Persistence $db) 
    {
        
    }
}
```

or by resolving directly through the service container

```php
$db = $this->app->make('agiledata'); // using the alias
$db = $this->app->make(atk4\data\Persistence::class); // using the class name
```


## Roadmap

 - [x] DI integration
 - [ ] Facade for retrieving different `Persistence` objects
 - [ ] Authentication UserProvider
 - [ ] Migrations using Console
 - [ ] Support route validations that use DB
 - [ ] Support Laravel Collections?
