<?php

namespace App\Filament\Admin\Resources\Applicants\Pages;

use App\Filament\Admin\Resources\Applicants\ApplicantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;

class ListApplicants extends ListRecords
{
    protected static string $resource = ApplicantResource::class;

    public function getMaxContentWidth(): ?string
    {
        return Width::Full->value;   
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }


}
