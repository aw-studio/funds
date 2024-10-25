<?php

namespace Funds\Foundation\Providers;

use Funds\Foundation\Core;
use Funds\Foundation\Navigation;
use Funds\Foundation\PaymentGatewayResolver;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;
use NumberFormatter;

class FoundationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(ExtensionsServiceProvider::class);

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
        $this->mergeConfigFrom(__DIR__.'/../../config/funds.php', 'funds');

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
