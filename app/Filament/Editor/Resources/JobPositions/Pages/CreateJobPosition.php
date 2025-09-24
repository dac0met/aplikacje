<?php

namespace App\Filament\Editor\Resources\JobPositions\Pages;

use App\Filament\Editor\Resources\JobPositions\JobPositionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJobPosition extends CreateRecord
{
    protected static string $resource = JobPositionResource::class;
}
