<?php

namespace App\Filament\Manager\Resources\Applicants\Pages;

use App\Filament\Manager\Resources\Applicants\ApplicantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApplicant extends CreateRecord
{
    protected static string $resource = ApplicantResource::class;
}
