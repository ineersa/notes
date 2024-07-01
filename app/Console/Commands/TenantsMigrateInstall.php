<?php

namespace App\Console\Commands;

use App\Console\Traits\TenantsCommandTrait;
use App\Console\Traits\TenantsMigrationsPathTrait;
use App\Console\Traits\TenantsOptionTrait;
use App\Models\UserDatabase;
use App\Services\UserDatabasesService;
use Illuminate\Console\Command;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;

class TenantsMigrateInstall extends Command
{
    use TenantsCommandTrait;
    use TenantsMigrationsPathTrait;
    use TenantsOptionTrait;

    protected $description = 'Install migrations for tenant(s)';

    private MigrationRepositoryInterface $repository;

    private UserDatabasesService $userDatabasesService;

    protected static function getTenantCommandName(): string
    {
        return 'tenants:migrate-install';
    }

    public function __construct(MigrationRepositoryInterface $repository, UserDatabasesService $userDatabasesService)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->userDatabasesService = $userDatabasesService;
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
        $this->setDatabaseOption();
        /** @var UserDatabase $tenant */
        foreach ($this->getTenants() as $tenant) {
            $this->userDatabasesService->setupDatabase($tenant->user_id);

            $this->repository->setSource($this->input->getOption('database'));
            $this->repository->createRepository();

            $this->components->info('Migration table created successfully for tenant #'.$tenant->user_id);
        }

        return self::SUCCESS;
    }
}
