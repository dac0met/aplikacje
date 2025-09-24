<?php

namespace App\Filament\Manager\Resources\Applicants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApplicantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('submission_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('job_position_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('submitted_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('user_ip')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('surname')
                    ->searchable(),
                TextColumn::make('yob')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('phone')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('consent')
                    ->searchable(),
                TextColumn::make('job_position')
                    ->searchable(),
                TextColumn::make('education')
                    ->searchable(),
                TextColumn::make('english')
                    ->searchable(),
                TextColumn::make('another_lang')
                    ->searchable(),
                TextColumn::make('another_level')
                    ->searchable(),
                TextColumn::make('shift_work')
                    ->searchable(),
                TextColumn::make('salary')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cv_pl')
                    ->searchable(),
                TextColumn::make('cv_gb')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('english_rating')
                    ->searchable(),
                TextColumn::make('info')
                    ->searchable(),
                TextColumn::make('sent_to')
                    ->searchable(),
                TextColumn::make('interview')
                    ->searchable(),
                TextColumn::make('feedback')
                    ->searchable(),
                TextColumn::make('gender')
                    ->searchable(),
                TextColumn::make('gross')
                    ->searchable(),
                TextColumn::make('consent_source')
                    ->searchable(),
                TextColumn::make('notes')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
