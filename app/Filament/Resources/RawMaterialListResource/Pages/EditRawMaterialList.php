<?php

namespace App\Filament\Resources\RawMaterialListResource\Pages;

use App\Filament\Resources\RawMaterialListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRawMaterialList extends EditRecord
{
    protected static string $resource = RawMaterialListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
