<?php

namespace App\Filament\Admin\Resources\ConsentSources\Pages;

use App\Filament\Admin\Resources\ConsentSources\ConsentSourceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditConsentSource extends EditRecord
{
    protected static string $resource = ConsentSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
