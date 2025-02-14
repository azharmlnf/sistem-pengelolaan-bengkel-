<?php

namespace App\Filament\Resources\MechanicResource\Pages;

use App\Filament\Resources\MechanicResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMechanic extends ViewRecord
{
    protected static string $resource = MechanicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
