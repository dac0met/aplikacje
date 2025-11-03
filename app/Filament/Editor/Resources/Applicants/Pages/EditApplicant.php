<?php

namespace App\Filament\Editor\Resources\Applicants\Pages;

use App\Filament\Editor\Resources\Applicants\ApplicantResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditApplicant extends EditRecord
{
    protected static string $resource = ApplicantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getMaxContentWidth(): ?string
    {
        return Width::Full->value;   
    }
}
