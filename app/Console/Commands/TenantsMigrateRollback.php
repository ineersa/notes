<?php

namespace App\Console\Commands;

use App\Console\Traits\TenantsCommandTrait;
use App\Console\Traits\TenantsMigrationsPathTrait;
use App\Console\Traits\TenantsOptionTrait;
use App\Models\UserDatabase;
use App\Services\UserDatabasesService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Console\Migrations\RollbackCommand;
use Illuminate\Database\Migrations\Migrator;

class TenantsMigrateRollback extends RollbackCommand
{
    use TenantsCommandTrait;
    use TenantsMigrationsPathTrait;
    use TenantsOptionTrait;

    protected $description = 'Rollback migrations for tenant(s)';

    protected static function getTenantCommandName(): string
    {
        return 'tenants:migrate-rollback';
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

            $this->migrator->usingConnection($this->option('database'), function () {
                $this->migrator->setOutput($this->output)->rollback(
                    $this->getMigrationPaths(), [
                        'pretend' => $this->option('pretend'),
                        'step' => (int) $this->option('step'),
                        'batch' => (int) $this->option('batch'),
                    ]
                );
            });
        }

        return self::SUCCESS;
    }
}
