<?php

namespace App\Filament\Editor\Resources\JobPositions\Pages;

use App\Filament\Editor\Resources\JobPositions\JobPositionResource;
use Filament\Actions\DeleteAction;
// use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditJobPosition extends EditRecord
{
    protected static string $resource = JobPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
