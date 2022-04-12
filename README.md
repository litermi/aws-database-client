# Aws database client

[![Software License][ico-license]](LICENSE.md)

## About

The `aws database client` package to search database client aws .

##### [Tutorial how create composer package](https://cirelramos.blogspot.com/2022/04/how-create-composer-package.html)

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


The defaults are set in `config/aws-database-client.php`. Publish the config to copy the file to your own config:
```sh
php artisan vendor:publish --provider="Cirelramos\Database\Providers\ServiceProvider"
```

> **Note:** this is necessary to yo can change default config



## Usage

add provider in config/app.php

```php
    'providers' => [
        CirelRamos\Database\Providers\DatabaseServiceProvider::class,
   ]
```

change in config/database.php

```php
    $mysqlConnection = env('TYPE_MYSQL_CONNECTION', null);

    $mysql = [
        'driver' => 'vault',
    ];

    if ($mysqlConnection === 'local' || $mysqlConnection === null) {
        $mysql = [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'apitrillo'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'root'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET_MYSQL', 'utf8mb4'),
            'collation' => env('DB_COLLECTION_MYSQL' , 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'modes' => [
                'NO_UNSIGNED_SUBTRACTION',
                'NO_ENGINE_SUBSTITUTION',
            ],
            'engine' => null,
        ];
    }

$database = [

    //    .
    //    .

    'connections' => [

        //        .
        //        .

        'mysql' => $mysql,
        
        //        .
        //        .
     ]
]

return $database;
```



## License

Released under the MIT License, see [LICENSE](LICENSE).


[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

