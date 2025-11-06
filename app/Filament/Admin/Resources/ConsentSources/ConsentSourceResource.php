<?php

namespace App\Filament\Admin\Resources\ConsentSources;

use App\Filament\Admin\Resources\ConsentSources\Pages\CreateConsentSource;
use App\Filament\Admin\Resources\ConsentSources\Pages\EditConsentSource;
use App\Filament\Admin\Resources\ConsentSources\Pages\ListConsentSources;
use App\Filament\Admin\Resources\ConsentSources\Schemas\ConsentSourceForm;
use App\Filament\Admin\Resources\ConsentSources\Schemas\ConsentSourceInfolist;
use App\Filament\Admin\Resources\ConsentSources\Tables\ConsentSourcesTable;
use App\Models\ConsentSource;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ConsentSourceResource extends Resource
{
    protected static ?string $model = ConsentSource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CodeBracket;

    protected static ?string $recordTitleAttribute = 'Name';

    public static function form(Schema $schema): Schema
    {
        return ConsentSourceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ConsentSourceInfolist::configure($schema);
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
