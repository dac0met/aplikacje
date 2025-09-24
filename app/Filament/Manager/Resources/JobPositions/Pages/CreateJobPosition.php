<?php

namespace App\Filament\Manager\Resources\JobPositions\Pages;

use App\Filament\Manager\Resources\JobPositions\JobPositionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJobPosition extends CreateRecord
{
    protected static string $resource = JobPositionResource::class;
}
