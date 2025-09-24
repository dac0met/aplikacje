<?php

namespace App\Filament\Editor\Resources\JobPositions\Pages;

use App\Filament\Editor\Resources\JobPositions\JobPositionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJobPosition extends ViewRecord
{
    protected static string $resource = JobPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
