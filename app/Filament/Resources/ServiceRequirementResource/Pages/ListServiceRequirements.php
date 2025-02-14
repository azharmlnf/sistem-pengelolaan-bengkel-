<?php

namespace App\Filament\Resources\ServiceRequirementResource\Pages;

use App\Filament\Resources\ServiceRequirementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceRequirements extends ListRecords
{
    protected static string $resource = ServiceRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
