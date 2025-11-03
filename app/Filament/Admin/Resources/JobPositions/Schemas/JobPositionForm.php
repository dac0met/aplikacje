<?php

namespace App\Filament\Admin\Resources\JobPositions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JobPositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                TextInput::make('filename')
                    ->label('Filename'),
            ]);
    }
}
