<?php

namespace App\Filament\Resources\MembershipResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\MembershipResource;

class ViewQrCode extends ViewRecord
{
    protected static string $resource = MembershipResource::class;

    protected static string $view = 'filament.resources.membership-resource.pages.view-qr-code';

    protected function getHeaderActions(): array
    {
        return [];
    }
}