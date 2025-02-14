<?php

namespace App\Filament\Resources\ServiceAssignmentResource\Pages;

use App\Filament\Resources\ServiceAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceAssignments extends ListRecords
{
    protected static string $resource = ServiceAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
