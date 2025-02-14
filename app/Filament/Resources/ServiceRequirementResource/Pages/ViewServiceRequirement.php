<?php

namespace App\Filament\Resources\ServiceRequirementResource\Pages;

use App\Filament\Resources\ServiceRequirementResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewServiceRequirement extends ViewRecord
{
    protected static string $resource = ServiceRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
