<?php

namespace App\Filament\Resources\SupplierListResource\Pages;

use App\Filament\Resources\SupplierListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupplierLists extends ListRecords
{
    protected static string $resource = SupplierListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
