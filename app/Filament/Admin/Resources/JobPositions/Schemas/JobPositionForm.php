<?php

namespace App\Filament\Admin\Resources\JobPositions\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class JobPositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('')
                    ->columns(1)
                    ->schema([
                    Radio::make('published')
                        ->label('Published')
                        ->boolean()
                        ->inline(true)
                        ->default(false),
                    TextInput::make('name')
                        ->label('Name')
                        ->required(),
                    TextInput::make('filename')
                        ->label('Filename'),
                    ])
            ]);
    }
}
