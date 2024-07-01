<?php

namespace App\Console\Commands;

use App\Console\Traits\TenantsCommandTrait;
use App\Console\Traits\TenantsMigrationsPathTrait;
use App\Console\Traits\TenantsOptionTrait;
use App\Models\UserDatabase;
use App\Services\UserDatabasesService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Database\Migrations\Migrator;

class TenantsMigrate extends MigrateCommand
{
    use TenantsCommandTrait;
    use TenantsMigrationsPathTrait;
    use TenantsOptionTrait;

    protected $description = 'Run migrations for tenant(s)';

    protected static function getTenantCommandName(): string
    {
        return 'tenants:migrate';
    }

    public function __construct(
        Migrator $migrator,
        Dispatcher $dispatcher,
        private readonly UserDatabasesService $userDatabasesService
    ) {
        parent::__construct($migrator, $dispatcher);

        $this->specifyTenantSignature();
    }

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws \Throwable
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return self::FAILURE;
        }

        $this->setDatabaseOption();
        /** @var UserDatabase $tenant */
        foreach ($this->getTenants() as $tenant) {
            $this->userDatabasesService->setupDatabase($tenant->user_id);

            try {
                $this->runMigrations();
                $this->components->info('Migrations applied for tenant #'.$tenant->user_id);
            } catch (\Throwable $e) {
                if ($this->option('graceful')) {
                    $this->components->warn($e->getMessage());

                    return self::SUCCESS;
                }

                throw $e;
            }
        }

        return self::SUCCESS;
    }
}
