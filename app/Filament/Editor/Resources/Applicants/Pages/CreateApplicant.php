<?php

namespace App\Filament\Editor\Resources\Applicants\Pages;

use App\Filament\Editor\Resources\Applicants\ApplicantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApplicant extends CreateRecord
{
    protected static string $resource = ApplicantResource::class;
}
