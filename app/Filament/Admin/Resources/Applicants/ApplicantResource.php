<?php

namespace App\Filament\Admin\Resources\Applicants;

use App\Filament\Admin\Resources\Applicants\Pages\CreateApplicant;
use App\Filament\Admin\Resources\Applicants\Pages\EditApplicant;
use App\Filament\Admin\Resources\Applicants\Pages\ListApplicants;
use App\Filament\Admin\Resources\Applicants\Schemas\ApplicantForm;
use App\Filament\Admin\Resources\Applicants\Tables\ApplicantsTable;
use App\Models\Applicant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApplicantResource extends Resource
{
    protected static ?string $model = Applicant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Name';

    public static function form(Schema $schema): Schema
    {
        return ApplicantForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicantsTable::configure($table);
    }

    // public static function getRelations(): array
    // {
    //     return [
    //         //
    //     ];
    // }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with('jobPositions');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApplicants::route('/'),
            'create' => CreateApplicant::route('/create'),
            'edit' => EditApplicant::route('/{record}/edit'),
        ];
    }


}
