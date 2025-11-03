<?php

namespace App\Filament\Editor\Resources\ConsentSources\Pages;

use App\Filament\Editor\Resources\ConsentSources\ConsentSourceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditConsentSource extends EditRecord
{
    protected static string $resource = ConsentSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
