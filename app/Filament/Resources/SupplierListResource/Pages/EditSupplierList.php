<?php

namespace App\Filament\Resources\SupplierListResource\Pages;

use App\Filament\Resources\SupplierListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupplierList extends EditRecord
{
    protected static string $resource = SupplierListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
