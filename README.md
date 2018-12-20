## Laravel Settings

[![Latest Version on Packagist](https://img.shields.io/packagist/v/qcod/laravel-settings.svg)](https://packagist.org/packages/qcod/laravel-settings)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/qcod/laravel-settings/master.svg)](https://travis-ci.org/qcod/laravel-settings)
[![StyleCI](https://styleci.io/repos/152258044/shield)](https://styleci.io/repos/152258044)
[![Total Downloads](https://img.shields.io/packagist/dt/qcod/laravel-settings.svg)](https://packagist.org/packages/qcod/laravel-settings)

Use `qcod/laravel-settings` to store key value pair settings in the database.

> All the settings saved in db is cached to improve performance by reducing sql query to zero.

### Installation

**1** - You can install the package via composer:

```bash
$ composer require qcod/laravel-settings
```

**2** - If you are installing on Laravel 5.4 or lower you will be needed to manually register Service Provider by adding it in `config/app.php` providers array and Facade in aliases arrays.

```php
'providers' => [
    //...
    QCod\Settings\SettingsServiceProvider::class
]

'aliases' => [
    //...
    "Settings" => QCod\Settings\Facade::class
]
```

In Laravel 5.5 or above the service provider automatically get registered and a facade `Setting::get('app_name')` will be available.

**3** - Now run the migration by `php artisan migrate` to create the settings table.

Optionally you can publish migration by running

```
php artisan vendor:publish --provider="QCod\Settings\SettingsServiceProvider" --tag="migrations"
```

### Getting Started

You can use helper function `settings('app_name')` or `Settings::get('app_name')` to use laravel settings.

### Available methods

```php
// Pass `true` to ignore cached settings
settings()->all($fresh = false);

// Get a single setting
settings()->get($key, $defautl = null);

// Set a single setting
settings()->set($key, $value);

// Set a multiple settings
settings()->set([
   'app_name' => 'QCode',
   'app_email' => 'info@email.com',
   'app_type' => 'SaaS'
]);

// check for setting key
settings()->has($key);

// remove a setting
settings()->remove($key);
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### Testing

The package contains some integration/smoke tests, set up with Orchestra. The tests can be run via phpunit.

```bash
$ composer test
```

### Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email saquibweb@gmail.com instead of using the issue tracker.

### Credits

- [Mohd Saqueib Ansari](https://github.com/saqueib)

### About QCode.in

QCode.in (https://www.qcode.in) is blog by [Saqueib](https://github.com/saqueib) which covers All about Full Stack Web Development.

### License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
