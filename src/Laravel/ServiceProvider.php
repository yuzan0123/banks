<?php

namespace Xyu\Banks\Laravel;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Laravel\Lumen\Application;
use Xyu\Banks\Factory;
use Xyu\Banks\BankApp;

/**
 * Class ServiceProvider
 *
 * @package Xyu\Banks
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = dirname(__DIR__).'/config/bank.php';
        if ($this->app->runningInConsole()) {
            $this->publishes([$source => base_path('config/bank.php')], 'bank');
        }

        if ($this->app instanceof Application) {
            $this->app->configure('bank');
        }

        $this->mergeConfigFrom($source, 'bank');
    }

    public function register()
    {
        $this->setupConfig();

        $this->app->singleton(BankApp::class, function ($app) {
            return app(Factory::class)->make();
        });

        $this->app->singleton(Factory::class, function ($app) {
            return new Factory(config('bank'));
        });

        $this->app->alias(Factory::class, 'bank.factory');
        $this->app->alias(BankApp::class, 'bank.pay');
    }
}