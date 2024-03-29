## Laravel IDE Facade Helper

<img src="https://preview.dragon-code.pro/TheDragonCode/ide-facades-helper.svg?brand=laravel" alt="Laravel IDE Facade Helper"/>

<p align="center">
    <a href="https://packagist.org/packages/dragon-code/laravel-ide-facades-helper"><img src="https://img.shields.io/packagist/dt/dragon-code/laravel-ide-facades-helper.svg?style=flat-square" alt="Total Downloads" /></a>
    <a href="https://packagist.org/packages/dragon-code/laravel-ide-facades-helper"><img src="https://poser.pugx.org/dragon-code/laravel-ide-facades-helper/v/stable?format=flat-square" alt="Latest Stable Version" /></a>
    <a href="https://packagist.org/packages/dragon-code/laravel-ide-facades-helper"><img src="https://poser.pugx.org/dragon-code/laravel-ide-facades-helper/v/unstable?format=flat-square" alt="Latest Unstable Version" /></a>
</p>
<p align="center">
    <a href="https://styleci.io/repos/277866838"><img src="https://styleci.io/repos/277866838/shield" alt="StyleCI" /></a>
    <a href="LICENSE"><img src="https://poser.pugx.org/dragon-code/laravel-ide-facades-helper/license?format=flat-square" alt="License" /></a>
</p>

> Laravel IDE Facade Helper, generates correct PHPDocs for your Facade classes, to improve auto-completion.

> Note
> This package has been deprecated. Use the [Laravel Idea](https://plugins.jetbrains.com/plugin/13441-laravel-idea) plugin instead.


## Installation

Require this package with [composer](https://getcomposer.org) using the following command:

```bash
$ composer require dragon-code/laravel-ide-facades-helper --dev
```

This package makes use of [Laravels package auto-discovery mechanism](https://medium.com/@taylorotwell/package-auto-discovery-in-laravel-5-5-ea9e3ab20518), which means if you don't
install dev dependencies in production, it also won't be loaded.

If for some reason you want manually control this:

- add the package to the `extra.laravel.dont-discover` key in `composer.json`, e.g.
  ```json
  "extra": {
    "laravel": {
      "dont-discover": [
        "dragon-code/laravel-ide-facades-helper",
      ]
    }
  }
  ```
- Add the following class to the `providers` array in `config/app.php`:
  ```php
  DragonCode\LaravelIdeFacadesHelper\ServiceProvider::class,
  ```
  If you want to manually load it only in non-production environments, instead you can add this to your `AppServiceProvider` with the `register()` method:
  ```php
  public function register()
  {
      if ($this->app->environment() !== 'production') {
          $this->app->register(\DragonCode\LaravelIdeFacadesHelper\ServiceProvider::class);
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


[badge_contributors]:   https://img.shields.io/github/contributors/TheDragonCode/laravel-ide-facades-helper?style=flat-square

[link_author]:          https://github.com/TheDragonCode

[link_contributors]:    https://github.com/TheDragonCode/laravel-ide-facades-helper/graphs/contributors
