<?php

namespace atk4\LaravelAD;

use atk4\data\Persistence;
use Illuminate\Support\ServiceProvider;

class AgileDataServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/agiledata.php' => config_path('agiledata.php'),
        ], 'agiledata');
    }

    public function register()
    {
        if ($this->isLumen()) {
            $this->app->configure('database');
            $this->app->configure('agiledata');
        }

        $this->registerPersistence();
    }

    protected function registerPersistence()
    {
        $this->app->singleton('agiledata', function ($app) {
            $config = $app->make('config');
            if ('default' === $connectionName = $config->get('agiledata.connection')) {
                $connectionName = $config->get('database.default');
            }
            $connectionDetails = $config->get('database.connections.'.$connectionName);
            $dsn = "{$connectionDetails['driver']}:";
            switch ($connectionDetails['driver']) {
                case 'mysql':
                    $dsn .= "host={$connectionDetails['host']};dbname={$connectionDetails['database']}";
                    break;
                case 'sqlite':
                    $dsn .= "{$connectionDetails['database']}";
                    break;
                default:
                    throw new \Exception('Driver must mysql or sqlite');
            }

            return Persistence::connect($dsn, Arr::get($connectionDetails,'username'), Arr::get($connectionDetails,'password'));
        });

        $this->app->alias('agiledata', Persistence::class);
    }

    /**
     * @return bool
     */
    protected function isLumen()
    {
        return str_contains($this->app->version(), 'Lumen');
    }
}
