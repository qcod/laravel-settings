## Laravel App Settings

[![Latest Version on Packagist](https://img.shields.io/packagist/v/qcod/laravel-settings.svg)](https://packagist.org/packages/qcod/laravel-settings)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/qcod/laravel-settings/master.svg)](https://travis-ci.org/qcod/laravel-settings)
[![Total Downloads](https://img.shields.io/packagist/dt/qcod/laravel-settings.svg)](https://packagist.org/packages/qcod/laravel-settings)

Use `qcod/laravel-settings` provides simple key value pair settings to store in database.

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
    QCod\Settings\AppSettingsServiceProvider::class
]

'aliases' => [
    //...
    "Settings" => QCod\Settings\Facade::class
]
```

In Laravel 5.5 or above the service provider automatically get registered and a facade `AppSettings::get('app_name')` will be available.

**3** - Now run the migration by `php artisan migrate` to create the settings table.

### Getting Started

Settings into db and don't want the UI to manage settings? for that simply use the helper function `setting()` or `AppSetting::get('app_name')` to store and retrieve settings from db. For this you don't need to define any section and inputs in `app_settings.php` config.

> Make sure to set `'remove_abandoned_settings' => false` in **config/app_settings.php** otherwise any undefined input fields will be removed on save from UI.

Here are list of available methods:

```php
// Pass `true` to ignore cached settings.
setting()->all($fresh = false);

// Get a single setting
setting()->get($key, $defautl = null);

// Set a single setting
setting()->set($key, $value);

// Set a multiple settings
setting()->set([
   'app_name' => 'QCode',
   'app_email' => 'info@email.com',
   'app_type' => 'SaaS'
]);

// check for setting key
setting()->has($key);

// remove a setting
setting()->remove($key);
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
