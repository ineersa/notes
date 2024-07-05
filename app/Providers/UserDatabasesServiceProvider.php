<?php

namespace App\Providers;

use App\Services\UserDatabasesService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class UserDatabasesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserDatabasesService::class, function (Application $app) {
            return new UserDatabasesService(
                $app->get('encrypter'),
            );
        });
    }

    public function boot() {}
}
