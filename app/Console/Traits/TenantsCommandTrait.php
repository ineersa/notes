<?php

namespace App\Console\Traits;

use App\Services\UserDatabasesService;

trait TenantsCommandTrait
{
    protected function specifyTenantSignature(): void
    {
        $this->specifyParameters();
    }

    public function getName(): ?string
    {
        return static::getTenantCommandName();
    }

    public static function getDefaultName(): ?string
    {
        return static::getTenantCommandName();
    }

    public function setDatabaseOption(): void
    {
        if ($this->input->hasOption('database') && $this->input->getOption('database')) {
            return;
        }

        $this->input->setOption('database', UserDatabasesService::CONNECTION_NAME);
    }

    abstract protected static function getTenantCommandName(): string;
}
