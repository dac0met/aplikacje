<?php

namespace App\Filament\Admin\Resources\Applicants\Tables;

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
                ->toggleable(isToggledHiddenByDefault: false)
                ->searchable(),

            // Foreign keys / relations
            TextColumn::make('submission_id')
                ->label('Submission ID')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false)
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
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),


            // Simple strings / chars
            TextColumn::make('user_ip')
                ->label('IP')
                ->toggleable(isToggledHiddenByDefault: false)
                ->limit(15),

            TextColumn::make('name')
                ->label('First Name')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('surname')
                ->label('Last Name')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('yob')
                ->label('Year of Birth')
                ->numeric()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('city')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('phone')
                ->label('Phone')
                ->numeric()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('email')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('consent')
                ->label('Consent')
                ->toggleable(isToggledHiddenByDefault: false)
                ->limit(10),

            TextColumn::make('job_position')
                ->label('Job Position (text)')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('education')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('university')
                ->limit(50)
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('field_of_study')
                ->limit(50)
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('english')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('another_lang')
                ->label('Other Language')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('another_level')
                ->label('Other Language Level')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('experience')
                ->limit(80)
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            BooleanColumn::make('shift_work')
                ->label('Shift Work')
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('salary')
                ->numeric()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('cv_pl')
                ->label('CV (PL)')
                ->url(fn ($record) => storage_path('app/' . $record->cv_pl))
                ->openUrlInNewTab()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('cv_gb')
                ->label('CV (GB)')
                ->url(fn ($record) => storage_path('app/' . $record->cv_gb))
                ->openUrlInNewTab()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('status')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('english_rating')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('info')
                ->limit(100)
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('sent_to')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('interview')
                ->limit(120)
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('feedback')
                ->limit(120)
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('gender')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('gross')
                ->numeric()
                ->suffix('k')
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('consent_source')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
                ->sortable(),

            TextColumn::make('notes')
                ->limit(80)
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: false)
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
