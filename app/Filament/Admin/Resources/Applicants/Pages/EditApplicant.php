<?php

namespace App\Filament\Admin\Resources\Applicants\Pages;

use Filament\Support\Enums\Width;
// use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\Applicants\ApplicantResource;

class EditApplicant extends EditRecord
{
    protected static string $resource = ApplicantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }

    public function getMaxContentWidth(): ?string
    {
        return Width::Full->value;   
    }
}
