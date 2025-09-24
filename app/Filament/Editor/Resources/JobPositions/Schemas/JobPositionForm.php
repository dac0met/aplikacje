<?php

namespace App\Filament\Editor\Resources\JobPositions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JobPositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('filename')
                    ->required(),
            ]);
    }
}
