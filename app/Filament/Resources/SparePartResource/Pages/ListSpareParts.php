<?php

namespace App\Filament\Resources\SparePartResource\Pages;

use App\Filament\Resources\SparePartResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpareParts extends ListRecords
{
    protected static string $resource = SparePartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
