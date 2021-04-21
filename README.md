## Laravel IDE Facade Helper

Laravel IDE Facade Helper, generates correct PHPDocs for your Facade classes, to improve auto-completion.

<p align="center">
    <a href="https://packagist.org/packages/andrey-helldar/laravel-ide-facades-helper"><img src="https://img.shields.io/packagist/dt/andrey-helldar/laravel-ide-facades-helper.svg?style=flat-square" alt="Total Downloads" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/laravel-ide-facades-helper"><img src="https://poser.pugx.org/andrey-helldar/laravel-ide-facades-helper/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
    <a href="https://packagist.org/packages/andrey-helldar/laravel-ide-facades-helper"><img src="https://poser.pugx.org/andrey-helldar/laravel-ide-facades-helper/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
</p>
<p align="center">
    <a href="https://styleci.io/repos/277866838"><img src="https://styleci.io/repos/277866838/shield" alt="StyleCI" /></a>
    <a href="LICENSE"><img src="https://poser.pugx.org/andrey-helldar/laravel-ide-facades-helper/license?format=flat-square" alt="License" /></a>
</p>


## Installation

Require this package with [composer](https://getcomposer.org) using the following command:

```bash
$ composer require andrey-helldar/laravel-ide-facades-helper --dev
```

This package makes use of [Laravels package auto-discovery mechanism](https://medium.com/@taylorotwell/package-auto-discovery-in-laravel-5-5-ea9e3ab20518), which means if you don't install dev dependencies in production, it also won't be loaded.

If for some reason you want manually control this:
- add the package to the `extra.laravel.dont-discover` key in `composer.json`, e.g.
  ```json
  "extra": {
    "laravel": {
      "dont-discover": [
        "andrey-helldar/laravel-ide-facades-helper",
      ]
    }
  }
  ```
- Add the following class to the `providers` array in `config/app.php`:
  ```php
  Helldar\LaravelIdeFacadesHelper\ServiceProvider::class,
  ```
  If you want to manually load it only in non-production environments, instead you can add this to your `AppServiceProvider` with the `register()` method:
  ```php
  public function register()
  {
      if ($this->app->environment() !== 'production') {
          $this->app->register(\Helldar\LaravelIdeFacadesHelper\ServiceProvider::class);
      }
      // ...
  }
  ```

> Note: Avoid caching the configuration in your development environment, it may cause issues after installing this package; respectively clear the cache beforehand via `php artisan cache:clear` if you encounter problems when running the commands


## Usage

* `php artisan ide-helper:facades` - PHPDoc generation for your Facades

You can generate helpers for your facades.

You will find additional settings in the options `facade_locations` and `facades_visibility` of the `config/ide-helper.php` file.

> Note: The package uses the same file as [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper). Therefore, if you need to redefine the paths, add the configuration from [this](config/ide-helper.php) file to it.


## License

This package is licensed under the [MIT License](LICENSE).


## For Enterprise

Available as part of the Tidelift Subscription.

The maintainers of `andrey-helldar/laravel-ide-facades-helper` and thousands of other packages are working with Tidelift to deliver commercial support and maintenance for the open source packages you use to build your applications. Save time, reduce risk, and improve code health, while paying the maintainers of the exact packages you use. [Learn more](https://tidelift.com/subscription/pkg/packagist-andrey-helldar-laravel-ide-facades-helper?utm_source=packagist-andrey-helldar-laravel-ide-facades-helper&utm_medium=referral&utm_campaign=enterprise&utm_term=repo).


[badge_contributors]:   https://img.shields.io/github/contributors/andrey-helldar/laravel-ide-facades-helper?style=flat-square

[link_author]:          https://github.com/andrey-helldar
[link_contributors]:    https://github.com/andrey-helldar/laravel-ide-facades-helper/graphs/contributors
