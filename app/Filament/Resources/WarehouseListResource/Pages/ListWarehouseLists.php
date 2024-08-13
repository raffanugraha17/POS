<?php

namespace App\Filament\Resources\WarehouseListResource\Pages;

use App\Filament\Resources\WarehouseListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWarehouseLists extends ListRecords
{
    protected static string $resource = WarehouseListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
