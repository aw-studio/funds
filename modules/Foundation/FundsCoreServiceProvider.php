<?php

namespace Funds\Foundation;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FundsCoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerModuleServiceProviders();

        Route::macro('app', function ($callback) {
            Route::group([
                'middleware' => ['web', 'auth'],
                'prefix' => 'app',
                // 'as' => 'app.',
            ], $callback);
        });

        $this->app->bind('funds.core', fn () => new Core());
        $this->app->singleton('funds.payment', function ($app) {
            $resolver = new PaymentGatewayResolver();

            return $resolver;
        });

        $this->app->singleton('funds.navigation', function ($app) {
            return new Navigation();
        });

    }

    public function registerModuleServiceProviders()
    {
        $modulesPath = base_path('modules');

        foreach (File::directories($modulesPath) as $modulePath) {
            $moduleName = basename($modulePath);
            $namespace = 'Funds\\'.$moduleName;
            $providerClass = $namespace.'\\Providers\\'.$moduleName.'ServiceProvider';

            if (class_exists($providerClass)) {
                $this->app->register($providerClass);
            }

            if (class_exists($providerClass = $namespace.'\\'.$moduleName.'ServiceProvider')) {
                $this->app->register($providerClass);
            }
        }
    }

    public function boot(): void
    {
        $this->guessFactoryNamespaces();

        $this->mergeConfigFrom(__DIR__.'/config/funds.php', 'funds');

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
