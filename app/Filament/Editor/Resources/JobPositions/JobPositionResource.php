<?php

namespace App\Filament\Editor\Resources\JobPositions;

use App\Filament\Editor\Resources\JobPositions\Pages\CreateJobPosition;
use App\Filament\Editor\Resources\JobPositions\Pages\EditJobPosition;
use App\Filament\Editor\Resources\JobPositions\Pages\ListJobPositions;
use App\Filament\Editor\Resources\JobPositions\Pages\ViewJobPosition;
use App\Filament\Editor\Resources\JobPositions\Schemas\JobPositionForm;
use App\Filament\Editor\Resources\JobPositions\Schemas\JobPositionInfolist;
use App\Filament\Editor\Resources\JobPositions\Tables\JobPositionsTable;
use App\Models\JobPosition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JobPositionResource extends Resource
{
    protected static ?string $model = JobPosition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Name';

    public static function form(Schema $schema): Schema
    {
        return JobPositionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JobPositionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobPositionsTable::configure($table);
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
            'index' => ListJobPositions::route('/'),
            'create' => CreateJobPosition::route('/create'),
            'view' => ViewJobPosition::route('/{record}'),
            'edit' => EditJobPosition::route('/{record}/edit'),
        ];
    }
}
