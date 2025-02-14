<?php

namespace App\Filament\Resources\ServiceAssignmentResource\Pages;

use App\Filament\Resources\ServiceAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceAssignment extends EditRecord
{
    protected static string $resource = ServiceAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
