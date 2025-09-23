<?php

namespace App\Filament\Resources\Applicants\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;

class ApplicantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Primary key
            TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->searchable(),

            // Foreign keys / relations
            TextColumn::make('submission_id')
                ->label('Submission ID')
                ->sortable()
                ->searchable(),

            // TextColumn::make('job_position_id')
            //     ->label('Job Position')
            //     ->relationship('jobPosition', 'title')   // adjust relation name / column as needed
            //     ->sortable()
            //     ->searchable(),

            // Dates
            TextColumn::make('submitted_date')
                ->label('Submitted')
                ->date('d-m-Y')
                ->sortable(),


            // Simple strings / chars
            TextColumn::make('user_ip')
                ->label('IP')
                ->limit(15),

            TextColumn::make('name')
                ->label('First Name')
                ->searchable()
                ->sortable(),

            TextColumn::make('surname')
                ->label('Last Name')
                ->searchable()
                ->sortable(),

            TextColumn::make('yob')
                ->label('Year of Birth')
                ->numeric()
                ->sortable(),

            TextColumn::make('city')
                ->searchable()
                ->sortable(),

            TextColumn::make('phone')
                ->label('Phone')
                ->numeric()
                ->sortable(),

            TextColumn::make('email')
                ->searchable()
                ->sortable(),

            TextColumn::make('consent')
                ->label('Consent')
                ->limit(10),

            TextColumn::make('job_position')
                ->label('Job Position (text)')
                ->searchable()
                ->sortable(),

            TextColumn::make('education')
                ->searchable()
                ->sortable(),

            TextColumn::make('university')
                ->limit(50)
                ->searchable()
                ->sortable(),

            TextColumn::make('field_of_study')
                ->limit(50)
                ->searchable()
                ->sortable(),

            TextColumn::make('english')
                ->searchable()
                ->sortable(),

            TextColumn::make('another_lang')
                ->label('Other Language')
                ->searchable()
                ->sortable(),

            TextColumn::make('another_level')
                ->label('Other Language Level')
                ->searchable()
                ->sortable(),

            TextColumn::make('experience')
                ->limit(80)
                ->searchable()
                ->sortable(),

            BooleanColumn::make('shift_work')
                ->label('Shift Work')
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('salary')
                ->numeric()
                ->sortable(),

            TextColumn::make('cv_pl')
                ->label('CV (PL)')
                ->url(fn ($record) => storage_path('app/' . $record->cv_pl))
                ->openUrlInNewTab()
                ->sortable(),

            TextColumn::make('cv_gb')
                ->label('CV (GB)')
                ->url(fn ($record) => storage_path('app/' . $record->cv_gb))
                ->openUrlInNewTab()
                ->sortable(),

            TextColumn::make('status')
                ->searchable()
                ->sortable(),

            TextColumn::make('english_rating')
                ->searchable()
                ->sortable(),

            TextColumn::make('info')
                ->limit(100)
                ->searchable()
                ->sortable(),

            TextColumn::make('sent_to')
                ->searchable()
                ->sortable(),

            TextColumn::make('interview')
                ->limit(120)
                ->searchable()
                ->sortable(),

            TextColumn::make('feedback')
                ->limit(120)
                ->searchable()
                ->sortable(),

            TextColumn::make('gender')
                ->searchable()
                ->sortable(),

            TextColumn::make('gross')
                ->numeric()
                ->suffix('k')
                ->sortable(),

            TextColumn::make('consent_source')
                ->searchable()
                ->sortable(),

            TextColumn::make('notes')
                ->limit(80)
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
