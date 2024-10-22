<?php

namespace Funds\Foundation;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;
use NumberFormatter;

class FundsCoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerModuleServiceProviders();

        Route::macro(
            'app',
            fn ($callback) => Route::group([
                'middleware' => ['web', 'auth'],
                'prefix' => 'app',
                // 'as' => 'app.',
            ], $callback)
        );

        $this->app->bind('funds.core', Core::class);
        $this->app->singleton('funds.payment', PaymentGatewayResolver::class);
        $this->app->singleton('funds.navigation', Navigation::class);

    }

    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config/funds.php', 'funds');

        if ($this->app->runningInConsole()) {
            $this->guessFactoryNamespaces();
        }

        Number::useLocale(app()->getLocale());
        Number::useCurrency(config('funds.default_currency'));

        Number::macro('currencyWithoutDigits', function (int|float $number, ?string $in = null, ?string $locale = null) {
            $formatter = new NumberFormatter($locale ?? Number::defaultLocale(), NumberFormatter::CURRENCY);
            $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);

            return $formatter->formatCurrency($number, $in ?? Number::defaultCurrency());
        });

    }

    public function registerModuleServiceProviders(): void
    {
        $modulesPath = base_path('modules');

        foreach (File::directories($modulesPath) as $modulePath) {
            $moduleName = basename((string) $modulePath);
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
