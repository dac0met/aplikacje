<?php

namespace App\Filament\Admin\Resources\ConsentSources\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ConsentSourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
