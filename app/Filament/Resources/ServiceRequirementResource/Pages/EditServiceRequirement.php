<?php

namespace App\Filament\Resources\ServiceRequirementResource\Pages;

use App\Filament\Resources\ServiceRequirementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceRequirement extends EditRecord
{
    protected static string $resource = ServiceRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
