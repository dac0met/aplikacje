<?php

namespace App\Filament\Editor\Resources\ConsentSources;

use App\Filament\Editor\Resources\ConsentSources\Pages\CreateConsentSource;
use App\Filament\Editor\Resources\ConsentSources\Pages\EditConsentSource;
use App\Filament\Editor\Resources\ConsentSources\Pages\ListConsentSources;
use App\Filament\Editor\Resources\ConsentSources\Schemas\ConsentSourceForm;
use App\Filament\Editor\Resources\ConsentSources\Tables\ConsentSourcesTable;
use BackedEnum;
use App\Models\ConsentSource;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ConsentSourceResource extends Resource
{
    protected static ?string $model = ConsentSource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ConsentSourceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConsentSourcesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConsentSources::route('/'),
            'create' => CreateConsentSource::route('/create'),
            'edit' => EditConsentSource::route('/{record}/edit'),
        ];
    }
}
