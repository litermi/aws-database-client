<?php

namespace Litermi\Database\Providers;

use Litermi\Database\Extentions\DatabaseManager;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseServiceProvider as BaseDatabaseServiceProvider;

/**
 *
 */
class DatabaseServiceProvider extends BaseDatabaseServiceProvider
{
    protected function registerConnectionServices()
    {
        $this->app->singleton('db.factory', function ($app) {
            return new ConnectionFactory($app);
        });
        $this->app->singleton('db', function ($app) {
            return new DatabaseManager($app, $app['db.factory']);
        });
        $this->app->bind('db.connection', function ($app) {
            return $app['db']->connection();
        });
    }
}
