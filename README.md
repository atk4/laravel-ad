A drop-in integration for [Laravel 5+](http://laravel.com) to allow use of [Agile Data](http://git.io/ad) natively.


[![Build Status](https://travis-ci.org/atk4/laravel-ad.png?branch=develop)](https://travis-ci.org/atk4/laravel-ad)
[![Code Climate](https://codeclimate.com/github/atk4/laravel-ad/badges/gpa.svg)](https://codeclimate.com/github/atk4/laravel-ad)
[![StyleCI](https://styleci.io/repos/56442737/shield)](https://styleci.io/repos/56442737)
[![Test Coverage](https://codeclimate.com/github/atk4/laravel-ad/badges/coverage.svg)](https://codeclimate.com/github/atk4/laravel-ad/coverage)
[![Version](https://badge.fury.io/gh/atk4%2Flaravel-ad.svg)](https://packagist.org/packages/atk4/laravel-ad)

``` php
example
```

## Roadmap

Essential: (absolutely needed)
* [ServiceProvider](https://laravel.com/docs/master/providers) -- This is the entry point for registering *any* third-party library with laravel. 
* [Registering AD with the DI container](https://laravel.com/docs/master/container) -- Wiring up AD. At the bare minimum there would need to be a binding that resolved `return \atk4\data\Persistence::connect(PDO_DSN, USER, PASS);` so the user can get a `$db` instance
  Important: (if you want to make it easier for migrating from Eloquent)
* [Migration console commands](https://laravel.com/docs/master/migrations) -- Eloquent provides console commands that let a user migrate up/down based on model changes. I know AD already has an extension for this so it would just be a matter of writing the commands to use AD
* [Auth](https://laravel.com/docs/master/authentication#adding-custom-user-providers) -- Need to write a user provider so that laravel's built in auth can get and verify a user
  Nice To Have:
* [Validation that uses DB](https://laravel.com/docs/5.3/validation#available-validation-rules) -- A couple route validation methods access the database (exists, unique). These would need to be overridden with custom validators (in the ServiceProvider)
* [Collections](https://laravel.com/docs/5.3/collections) -- This might be better for the **Important** category but i don't know how much they are used. Any set of entities loaded from Eloquent are a `Collection`. They support a bunch of in memory functional methods like `pluck, map, etc.`. Having a model init with their many relationships loaded as a laravel `Collection` would definitely help people who rely heavily on them already.
