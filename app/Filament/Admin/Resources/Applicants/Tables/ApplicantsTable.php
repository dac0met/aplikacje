<?php

namespace App\Filament\Admin\Resources\Applicants\Tables;

use App\Models\Applicant;
use App\Traits\GeneratesSearchHashes;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;

class ApplicantsTable
{
    use GeneratesSearchHashes;


    public static function configure(Table $table): Table
    {
        return $table
            ->header(view('components.table-header-pagination', [
                'table' => $table
            ]))
            ->columns([
                // Primary key
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),

                TextColumn::make('user_ip')
                    ->label('IP')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(15),

                IconColumn::make('confirmation')
                    ->label('Confirmed')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                TextColumn::make('submitted_date')
                    ->label('Submitted')
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('firstname')
                    ->label('First Name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->searchByFirstname($search);
                    })
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(false), // Wyłączamy sortowanie po hashach

                TextColumn::make('lastname')
                    ->label('Last Name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->searchByLastname($search);
                    })
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(false), // Wyłączamy sortowanie po hashach

                TextColumn::make('yob')
                    ->label('Year of Birth')
                    // ->mask('9999')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('consentsource.name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                TextColumn::make('city')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    // ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                // Kolumna z nazwami stanowisk (many-to-many)
                TextColumn::make('position')
                    ->label('Selected positions')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->wrap()
                    ->getStateUsing(function (Applicant $record) {
                        return $record->jobPositions
                            ? $record->jobPositions->pluck('name')->join(', ')
                            : null;
                    }),

                // TextColumn::make('jobposition.name')
                //     ->label('Job Position')
                //     ->columnSpan(4)
                //     ->searchable()
                //     ->wrap()
                //     ->toggleable(isToggledHiddenByDefault: false)
                //     ->sortable(),

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

                TextColumn::make('english_rating')
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

                TextColumn::make('salary')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('gross')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                IconColumn::make('shift_work')
                    ->label('Shift Work')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                TextColumn::make('consent')
                    ->label('Consent to recruitment')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                TextColumn::make('experience')
                    ->limit(80)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                TextColumn::make('notes')
                    ->limit(80)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                TextColumn::make('orig_filename_pl')
                    ->label('CV Filename pl')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('orig_filename_gb')
                    ->label('CV Filename gb')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('cv_pl')
                    // ->getStateUsing(fn (array $record): string => $record['name'] . ' ' . $record['surname'])
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('cv_gb')
                    // ->getStateUsing(fn (array $record): string => $record['name'] . ' ' . $record['surname'])
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('gender')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('status')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                TextColumn::make('sent_to')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                TextColumn::make('feedback')
                    ->limit(120)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('interview')
                    ->limit(120)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

            ])->paginated([5, 10, 25, 50])
            ->defaultSort('id','DESC')
            ->modifyQueryUsing(fn (Builder $query) => $query->with('jobPositions'))
            ->filters([
                SelectFilter::make('positions')
                    ->label('Positions')
                    // ->multiple()
                    ->relationship('jobPositions','name')
                    ->preload()
                    ->searchable()
                    ->columnSpan(2),
                
                SelectFilter::make('english')->label('english level')
                    ->options(fn ():Array => Applicant::query()
                    ->select('english')
                    ->orderBy('english', 'asc')
                    ->distinct()->get()->pluck('english', 'english')->toArray()),

                TernaryFilter::make('shift_work')->queries(
                    true: fn (Builder $query) => $query->where('shift_work',true),
                    false: fn (Builder $query) => $query->where('shift_work',false),),

                Filter::make('created_from')
                    ->schema([
                        DatePicker::make('created_from'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('submitted_date', '>=', $date),
                            );
                    }),

                Filter::make('created_until')
                    ->schema([
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('submitted_date', '<=', $date),
                            );
                    }),

            ], layout: FiltersLayout::AboveContent)  // filtry nad tabelą + możliwość zwinięcia
            ->deferFilters(false)
            ->persistFiltersInSession() //utrzymanie filtra w sesji użytkownika
            ->reorderableColumns()
            ->filtersFormColumns(8)
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])
            
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                ]),
            ]);
    }
}
