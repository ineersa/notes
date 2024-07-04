<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
    public function getTabs(): array
    {
        return [
            Tab::make('All'),
            Tab::make('Admins')->modifyQueryUsing(function (Builder $query) {
                $query->where('is_admin', true);
            }),
            Tab::make('Active')->modifyQueryUsing(function (Builder $query) {
                $query->where('active', true);
            }),
            Tab::make('Banned')->modifyQueryUsing(function (Builder $query) {
                $query->where('active', false);
            }),
        ];
    }
}
