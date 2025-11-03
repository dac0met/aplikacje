<?php

namespace App\Filament\Editor\Resources\ConsentSources\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ConsentSourceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('key'),
                TextEntry::make('label'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
