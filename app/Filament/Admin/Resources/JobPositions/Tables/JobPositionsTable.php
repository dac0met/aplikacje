<?php

namespace App\Filament\Admin\Resources\JobPositions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JobPositionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")
                    ->label("ID")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                
                IconColumn::make('published')
                    ->label('Published')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),

                TextColumn::make('filename')
                    ->label('Filename')
                    ->url(function ($record) {
                        $fileBase = Str::of($record->name)->snake('_');
                        $finalName = (string) ($record->filename ?: (string) $fileBase);
                        if (!Str::of($finalName)->endsWith('.pdf')) { $finalName .= '.pdf'; }
                        $relativePath = 'job_descriptions/' . $finalName;
                        return Storage::disk('public')->exists($relativePath)
                            ? route('job-positions.pdf', $record)
                            : null; //brak pliku - link nieaktywny
                    })
                    ->openUrlInNewTab()
                    ->extraAttributes([
                        'class' => 'text-blue-600 hover:underline hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300'
                    ])
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),

                // TextColumn::make('filename')
                //     ->label('Filename')
                //     ->formatStateUsing(function ($state, $record) {
                //         $fileBase = Str::of($record->name)->snake('_');
                //         $finalName = (string) ($record->filename ?: (string) $fileBase);
                //         if (!Str::of($finalName)->endsWith('.pdf')) { $finalName .= '.pdf'; }
                //         $relativePath = 'job_descriptions/' . $finalName;

                //         if (!Storage::disk('public')->exists($relativePath)) {
                //             return e($state);
                //         }

                //         $url = route('job-positions.pdf', $record);
                //         $text = e($state);
                //         return "<a href=\"{$url}\" target=\"_blank\" rel=\"noopener\" class=\"text-blue-600 hover:underline hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300\">{$text}</a>";
                //     })
                //     ->html()
                //     ->toggleable(isToggledHiddenByDefault: false)
                //     ->searchable(),

                    
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
                TernaryFilter::make('published')
                    ->label('Published')
                    ->queries(
                        true: fn (Builder $query) => $query->where('published',true),
                        false: fn (Builder $query) => $query->where('published',false),
                    ),
                ], layout: FiltersLayout::AboveContent)
                ->deferFilters(false)
                ->persistFiltersInSession() //utrzymanie filtra w sesji użytkownika
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
