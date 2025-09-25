<?php

namespace App\Filament\Admin\Resources\ConsentSources\Pages;

use App\Filament\Admin\Resources\ConsentSources\ConsentSourceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewConsentSource extends ViewRecord
{
    protected static string $resource = ConsentSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
