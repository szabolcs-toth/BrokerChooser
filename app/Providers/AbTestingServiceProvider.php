<?php

namespace App\Providers;

use App\Services\ab\AbTestsService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AbTestingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Blade::if('ab', function ($abTestId) {
            return app(AbTestsService::class)->isRunning($abTestId);
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('ab-testing', function () {
            return new AbTestsService;
        });
    }
}
