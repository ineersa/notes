<?php

declare(strict_types=1);

namespace App\Console\Traits;

trait TenantsMigrationsPathTrait
{
    protected function getMigrationPaths()
    {
        if ($this->input->hasOption('path') && $this->input->getOption('path')) {
            return parent::getMigrationPaths();
        }

        return database_path('migrations/tenants');
    }
}
