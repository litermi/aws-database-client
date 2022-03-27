# aws database client

[![Software License][ico-license]](LICENSE.md)

## About

The `aws database client` package to search database client aws .


## Installation

Require the `cirelramos/aws-database-client` package in your `composer.json` and update your dependencies:
```sh
composer require cirelramos/aws-database-client
```


## Configuration

set provider

```php
'providers' => [
    // ...
    Cirelramos\Database\Providers\ServiceProvider::class,
],
```


The defaults are set in `config/cache-query.php`. Publish the config to copy the file to your own config:
```sh
php artisan vendor:publish --provider="Cirelramos\Database\Providers\ServiceProvider"
```

> **Note:** this is necessary to yo can change default config



## Usage

To cache for query you need use extend Class

```php
class Product extends CacheModel
{
}
```

To cache for query you need use methods: getFromCache or firstCache

```php
        return Product::query()
            ->where('active', ModelConst::ENABLED)
            ->with($relations)
            ->getFromCache(['*'], $tags);
```


if you want purge cache can use methods: saveWithCache, insertWithCache, deleteWithCache

```php
            $product = new Product();
            $product->saveWithCache();
```

```php
            Product::insertWithCache($values);
```

```php
            $product->deleteWithCache();
```



## License

Released under the MIT License, see [LICENSE](LICENSE).


[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

