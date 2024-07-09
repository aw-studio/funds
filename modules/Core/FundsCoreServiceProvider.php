<?php

namespace Funds\Core;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FundsCoreServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->guessFactoryNamespaces();

        $this->app->bind('funds.core', fn () => new Core());

        $this->mergeConfigFrom(__DIR__.'/config/funds.php', 'funds');

        $this->app->singleton('funds.payment', function ($app) {
            $resolver = new PaymentGatewayResolver();

            return $resolver;
        });
        Route::macro('app', function ($callback) {
            Route::group([
                'middleware' => ['web', 'auth'],
                'prefix' => 'app',
                // 'as' => 'app.',
            ], $callback);
        });

        $this->app->singleton('funds.navigation', function ($app) {
            return new Navigation();
        });

    }

    protected function guessFactoryNamespaces()
    {
        Factory::guessFactoryNamesUsing(function (string $modelName) {
            $moduleName = explode('\\', $modelName)[1];

            if (str_contains($modelName, $moduleName)) {
                $factoryClassName = 'Funds\\'.$moduleName.'\\Database\\Factories\\'.class_basename($modelName).'Factory';

                if (class_exists($factoryClassName)) {
                    return $factoryClassName;
                }
            }

            // default to the original factory namespace
            return 'Database\\Factories\\'.class_basename($modelName).'Factory';
        });
    }
}
