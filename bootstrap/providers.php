<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    \Turso\Driver\Laravel\LibSQLDriverServiceProvider::class,
    App\Providers\UserDatabasesServiceProvider::class,
    App\Providers\VoltServiceProvider::class,
];
