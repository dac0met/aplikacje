<?php

namespace App\Filament\Admin\Resources\JobPositions\Pages;

use App\Filament\Admin\Resources\JobPositions\JobPositionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJobPosition extends CreateRecord
{
    protected static string $resource = JobPositionResource::class;
}
