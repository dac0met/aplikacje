<?php

namespace App\Filament\Editor\Resources\ConsentSources\Pages;

use App\Filament\Editor\Resources\ConsentSources\ConsentSourceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListConsentSources extends ListRecords
{
    protected static string $resource = ConsentSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
