<?php

declare(strict_types=1);

namespace App\Console\Traits;

use App\Models\UserDatabase;
use Illuminate\Support\LazyCollection;
use Symfony\Component\Console\Input\InputOption;

trait TenantsOptionTrait
{
    protected function getOptions()
    {
        return array_merge([
            ['tenants', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, '', null],
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use'],
        ], parent::getOptions());
    }

    protected function getTenants(): LazyCollection
    {
        return UserDatabase::query()
            ->when($this->option('tenants'), function ($query) {
                $query->whereIn('user_id', $this->option('tenants'));
            })
            ->cursor();
    }
}
