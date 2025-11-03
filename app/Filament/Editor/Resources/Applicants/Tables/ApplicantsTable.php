<?php

namespace App\Filament\Editor\Resources\Applicants\Tables;

use App\Models\Applicant;
use App\Traits\GeneratesSearchHashes;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use App\Services\TablePreferences;
use Illuminate\Support\Facades\Auth;

class ApplicantsTable
{
    use GeneratesSearchHashes;


    public static function configure(Table $table): Table
    {
        $tableKey = 'editor.applicants';
        $visible = app(TablePreferences::class)->getVisibleColumns(Auth::id(), $tableKey);

        return $table
            ->header(view('components.table-header-pagination', [
                'table' => $table
            ]))
            ->columns([
                // Primary key
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('id', $visible))
                    ->searchable(),

                TextColumn::make('user_ip')
                    ->label('IP')
                    ->toggleable(isToggledHiddenByDefault: ! in_array('user_ip', $visible))
                    ->limit(15),

                TextColumn::make('submitted_date')
                    ->label('Submitted')
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: ! in_array('submitted_date', $visible))
                    ->sortable(),

                TextColumn::make('firstname')
                    ->label('First Name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->searchByFirstname($search);
                    })
                    ->toggleable(isToggledHiddenByDefault: ! in_array('firstname', $visible))
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
                    ->toggleable(isToggledHiddenByDefault: ! in_array('yob', $visible))
                    ->sortable(),

                TextColumn::make('consentsource.name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('consentsource.name', $visible))
                    ->sortable(),

                TextColumn::make('city')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('city', $visible))
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->searchByEmail($search);
                    })
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(false), // Wyłączamy sortowanie po hashach

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->searchByPhone($search);
                    })
                    // ->numeric()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('phone', $visible))
                    ->sortable(false), // Wyłączamy sortowanie po hashach

                // Kolumna z nazwami stanowisk (many-to-many)
                TextColumn::make('position')
                    ->label('Selected positions')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('position', $visible))
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
                    ->toggleable(isToggledHiddenByDefault: ! in_array('education', $visible))
                    ->sortable(),

                TextColumn::make('university')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('university', $visible))
                    ->sortable(),

                TextColumn::make('field_of_study')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('field_of_study', $visible))
                    ->sortable(),

                TextColumn::make('english')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('english', $visible))
                    ->sortable(),

                TextColumn::make('english_rating')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('english_rating', $visible))
                    ->sortable(),

                TextColumn::make('another_lang')
                    ->label('Other Language')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('another_lang', $visible))
                    ->sortable(),

                TextColumn::make('another_level')
                    ->label('Other Language Level')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('another_level', $visible))
                    ->sortable(),

                TextColumn::make('salary')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('salary', $visible))
                    ->sortable(),

                TextColumn::make('gross')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('gross', $visible))
                    ->sortable(),

                IconColumn::make('shift_work')
                    ->label('Shift Work')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('shift_work', $visible))
                    ->sortable(),

                TextColumn::make('consent')
                    ->label('Consent to recruitment')
                    ->toggleable(isToggledHiddenByDefault: ! in_array('consent', $visible))
                    ->sortable(),

                TextColumn::make('experience')
                    ->limit(80)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('experience', $visible))
                    ->sortable(),

                TextColumn::make('notes')
                    ->limit(80)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('notes', $visible))
                    ->sortable(),

                TextColumn::make('orig_filename_pl')
                    ->label('CV Filename pl')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('orig_filename_pl', $visible))
                    ->sortable(),

                TextColumn::make('orig_filename_gb')
                    ->label('CV Filename gb')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('orig_filename_gb', $visible))
                    ->sortable(),

                TextColumn::make('cv_pl')
                    // ->getStateUsing(fn (array $record): string => $record['name'] . ' ' . $record['surname'])
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('cv_pl', $visible)),

                TextColumn::make('cv_gb')
                    // ->getStateUsing(fn (array $record): string => $record['name'] . ' ' . $record['surname'])
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('cv_gb', $visible)),

                TextColumn::make('gender')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('gender', $visible))
                    ->sortable(),

                TextColumn::make('status')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('status', $visible))
                    ->sortable(),

                TextColumn::make('sent_to')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('sent_to', $visible))
                    ->sortable(),

                TextColumn::make('feedback')
                    ->limit(120)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('feedback', $visible))
                    ->sortable(),

                TextColumn::make('interview')
                    ->limit(120)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: ! in_array('interview', $visible))
                    ->sortable(),

            ])->paginated([5, 10, 25, 50])
            ->defaultSort('id','DESC')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('confirmation', true)->with('jobPositions'))
            ->filters([
                Filter::make('firstname_search')
                    ->label('Search by first name')
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('firstname')
                            ->label('First name')
                            ->placeholder('Type first name...')
                            ->live(debounce: 500),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            filled($data['firstname'] ?? null),
                            fn (Builder $q) => $q->searchByFirstname($data['firstname'])
                        );
                    }),

                Filter::make('lastname_search')
                    ->label('Search by last name')
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('lastname')
                            ->label('Last name')
                            ->placeholder('Type last name...')
                            ->live(debounce: 500),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            filled($data['lastname'] ?? null),
                            fn (Builder $q) => $q->searchByLastname($data['lastname'])
                        );
                    }),

                Filter::make('email_search')
                    ->label('Search by email')
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Type email...')
                            ->live(debounce: 500),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            filled($data['email'] ?? null),
                            fn (Builder $q) => $q->searchByEmail($data['email'])
                        );
                    }),

                Filter::make('phone_search')
                    ->label('Search by phone')
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('phone')
                            ->label('Phone')
                            ->placeholder('Type phone...')
                            ->live(debounce: 500),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            filled($data['phone'] ?? null),
                            fn (Builder $q) => $q->searchByPhone($data['phone'])
                        );
                    }),


                SelectFilter::make('positions')
                    ->label('Positions')
                    // ->multiple()
                    ->relationship('jobPositions','name')
                    ->preload()
                    ->searchable()
                    ->columnSpan(4),
                
                SelectFilter::make('english')
                    ->label('English level')
                    ->columnSpan(2)
                    ->options(fn ():Array => Applicant::query()
                    ->select('english')
                    ->orderBy('english', 'asc')
                    ->distinct()->get()->pluck('english', 'english')->toArray()),

                TernaryFilter::make('shift_work')
                    ->label('Shift work')
                    ->queries(
                        true: fn (Builder $query) => $query->where('shift_work',true),
                        false: fn (Builder $query) => $query->where('shift_work',false),
                    ),

                Filter::make('submitted_from')
                    ->label('Submitted from')
                    ->columnSpan(2)
                    ->schema([
                        DatePicker::make('submitted_from'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['submitted_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('submitted_date', '>=', $date),
                            );
                    }),

                Filter::make('submitted_until')
                    ->label('Submitted to')
                    ->columnSpan(2)
                    ->schema([
                        DatePicker::make('submitted_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['submitted_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('submitted_date', '<=', $date),
                            );
                    }),

            ], layout: FiltersLayout::AboveContent)  // filtry nad tabelą + możliwość zwinięcia
            ->deferFilters(false)
            ->persistFiltersInSession() //utrzymanie filtra w sesji użytkownika
            ->reorderableColumns()
            ->filtersFormColumns(16)
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
                Action::make('save_columns')
                    ->label('Save visible columns')
                    ->color('gray')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->schema([
                        CheckboxList::make('columns')
                            ->label('Visible columns')
                            ->options([
                                'id' => 'ID',
                                'user_ip' => 'IP',
                                'submitted_date' => 'Submitted',
                                'firstname' => 'First Name',
                                'lastname' => 'Last Name',
                                'yob' => 'Year of Birth',
                                'consentsource.name' => 'Consent Source',
                                'city' => 'City',
                                'email' => 'Email',
                                'phone' => 'Phone',
                                'position' => 'Selected positions',
                                'education' => 'Education',
                                'university' => 'University',
                                'field_of_study' => 'Field of Study',
                                'english' => 'English',
                                'english_rating' => 'English rating',
                                'another_lang' => 'Other Language',
                                'another_level' => 'Other Language Level',
                                'salary' => 'Salary',
                                'gross' => 'Gross',
                                'shift_work' => 'Shift Work',
                                'consent' => 'Consent to recruitment',
                                'experience' => 'Experience',
                                'notes' => 'Notes',
                                'orig_filename_pl' => 'CV Filename pl',
                                'orig_filename_gb' => 'CV Filename gb',
                                'cv_pl' => 'CV pl',
                                'cv_gb' => 'CV gb',
                                'gender' => 'Gender',
                                'status' => 'Status',
                                'sent_to' => 'Sent to',
                                'feedback' => 'Feedback',
                                'interview' => 'Interview',
                            ])
                            ->default($visible)
                            ->columns(2),
                    ])
                    ->action(function (array $data) use ($tableKey) {
                        app(TablePreferences::class)->saveVisibleColumns(Auth::id(), $tableKey, $data['columns'] ?? []);
                        Notification::make()->success()->title('Visible columns saved')->send();
                    }),
            ]);
    }
}
