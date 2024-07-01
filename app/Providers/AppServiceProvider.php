<?php

namespace App\Providers;

use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Migrator::class, function ($app) {
            return $app['migrator'];
        });
        $this->app->singleton(MigrationRepositoryInterface::class, function ($app) {
            return $app['migration.repository'];
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
