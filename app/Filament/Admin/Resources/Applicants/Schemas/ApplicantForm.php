<?php

namespace App\Filament\Admin\Resources\Applicants\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Schema;
// removed Button-based action; using built-in FileUpload downloadable instead
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\View;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Component;
use Filament\Forms\Components\DateTimePicker;


class ApplicantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('')->columnSpan('full')
                    ->columns(8)
                    ->schema([
                        TextInput::make('user_ip')
                            ->columnspan(1)
                            ->readOnly(true)
                            ->rule('ipv4'),
                        TextInput::make('id')
                            ->readOnly(true),
                    ]),

            // *******  obszar 1    ***********************************************
                Fieldset::make('')->columnSpan('full')
                    ->columns(12)
                    ->schema([
                        DatePicker::make('submitted_date')
                            ->columnspan(2),

                        TextInput::make('firstname')
                            ->columnspan(4)
                            ->required(),

                        TextInput::make('lastname')
                            ->columnspan(4)
                            ->required(),

                        Radio::make('gender')
                            ->columnspan(2)
                            ->options([
                                'female' => 'Female',
                                'male' => 'Male'
                            ])
                            ->inline()
                            ->default(null),

                        TextInput::make('yob')->label('Year of birth')
                            ->columnspan(1)
                            ->mask('9999')
                            ->default(null),

                        Select::make('consent_source_id')
                            ->label('Source of consent')
                            ->columnspan(4)
                            ->relationship('ConsentSource','name')
                            ->default(null),

                        // Select::make('consent_source_id')               // przechowujemy ID rekordu
                        //     ->label('Source of consent')
                        //     ->columnspan(4)
                        //     ->relationship('consentSource', 'label')   // relacja w modelu (patrz niżej), automatycznie pobiera label
                        //     // ->searchable()                              // możliwość wyszukiwania
                        //     ->placeholder('Select or enter a new value')
                        //     ->createOptionForm([                        // Formularz, który pojawi się po wpisaniu nowego tekstu
                        //         TextInput::make('key')
                        //             ->required()
                        //             ->unique(table: ConsentSource::class, column: 'key')
                        //             ->maxLength(100),

                        //         TextInput::make('label')
                        //             ->required()
                        //             ->maxLength(255),
                        //     ])
                        //     ->createOptionUsing(fn (array $data) =>                         // Zapisujemy nową opcję i zwracamy jej ID, żeby Select ją od razu wybrał
                        //         ConsentSource::create($data)->getKey())
                        //     ->required(),


                        TextInput::make('city')
                            ->columnspan(6)
                            ->default(null),

                        TextInput::make('phone')
                            ->columnspan(2)
                            ->tel()
                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                            ->default(null),

                        TextInput::make('email')
                            ->label('Email address')
                            ->columnspan(4)
                            ->email()
                            ->default(null),

                        Select::make('job_position_id')
                            ->label('Position')
                            ->columnspan(6)
                            ->relationship('jobPosition','name')
                            ->preload()
                            ->default(null),

                        Textarea::make('position')
                            ->columnspan(6)
                            // ->disabled()           // Nie zapisujemy tego pola – służy wyłącznie do wyświetlania
                            ->rows(3)                         // wysokość pola
                            ->placeholder('Brak wybranych stanowisk!')
                            ->label('Wybrane stanowiska')
                            ->afterStateHydrated(function ($component, $state) {
                                $record = $component->getRecord();
                                if ($record && $record->jobPositions) {
                                        $component->state(
                                        $record->jobPositions->pluck('name')->join("\n ")
                                    );
                                } else {
                                    $component->state($state); // zachowujemy dotychczasowy stan (pusty)
                                }
                            }),

                        TextInput::make('education')
                            ->columnspan(4)
                            ->default(null),

                        TextInput::make('university')
                            ->columnspan(4)
                            ->default(null),

                        TextInput::make('field_of_study')
                            ->columnSpan(4)
                            ->default(null),

                        Select::make('english')
                            ->columnspan(2)
                            ->options([
                                'A1' => 'A1',
                                'A2' => 'A2',
                                'B1' => 'B1',
                                'B2' => 'B2',
                                'C1' => 'C1',
                                'C2' => 'C2',
                            ])
                            ->native(false)
                            ->default(null),

                        TextInput::make('english_rating')
                            ->columnspan(2)
                            ->default(null),

                        TextInput::make('another_lang')
                            ->columnspan(2)
                            ->default(null),

                        TextInput::make('another_level')
                            ->columnspan(1)
                            ->default(null),

                        TextInput::make('salary')
                            ->columnspan(1)
                            ->numeric()
                            ->step(100)
                            ->default(null),

                        Radio::make('gross')
                            // ->columnspan(2)
                            ->options([
                                'brutto' => 'Brutto',
                                'netto' => 'Netto'
                            ])
                            ->default(null),

                        Radio::make('shift_work')
                            ->boolean()
                            ->default(false)
                            ->inline(false)
                            ->required(),

                        Radio::make('consent')
                            ->label('Consent to recruitment')
                            ->columnspan(2)
                            ->options([
                                'current' => 'Current',
                                'future' => 'Current and Future',
                            ]),
                ]),

            // *******  obszar plików CV  ***********************************************
                Fieldset::make('')->columnSpan('full')
                    ->columns(4)
                    ->schema([

                        //  PL – polska wersja CV
                        // ------------------------------
                        FileUpload::make('cv_pl')
                            // ->columns()
                            ->multiple(false)
                            ->storeFileNamesIn('orig_filename_pl')
                            ->downloadable(false)
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.oasis.opendocument.text',
                            ])
                            ->disk('local')
                            ->directory('pl')
                            ->visibility('private'),
                        View::make('filament.forms.download-link')
                            ->columnSpan(1)
                            ->hidden(fn ($record) => !($record && $record->cv_pl))
                            ->extraAttributes(['class' => 'py-2'])
                            ->viewData(fn ($record) => [
                                'url' => $record ? URL::temporarySignedRoute('applicants.download.cv_pl', now()->addMinutes(10), $record) : null,
                                'label' => 'Pobierz CV (pl)',
                            ]),

                        //   GB – angielska wersja CV
                        // ----------------------------------
                        FileUpload::make('cv_gb')
                            // ->columns(1)
                            ->multiple(false)
                            ->storeFileNamesIn('orig_filename_gb')
                            // ->downloadable()
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.oasis.opendocument.text',
                            ])
                            ->disk('local')
                            ->directory('gb')
                            ->visibility('private'),
                        View::make('filament.forms.download-link')
                            ->columnSpan(1)
                            ->hidden(fn ($record) => !($record && $record->cv_gb))
                            ->extraAttributes(['class' => 'py-2'])
                            ->viewData(fn ($record) => [
                                'url' => $record ? URL::temporarySignedRoute('applicants.download.cv_gb', now()->addMinutes(10), $record) : null,
                                'label' => 'Pobierz CV (ang.)',
                            ]),

                        // Placeholder::make('download_cv_gb_link')
                        //     // ->columns(1)
                        //     // ->badge()
                        //     ->columnSpan(1)
                        //     ->hidden(fn ($record) => !($record && $record->cv_gb))
                        //     ->content(fn ($record) => $record ? new HtmlString('<a href="' . URL::temporarySignedRoute('applicants.download.cv_gb', now()->addMinutes(10), $record) . '" class="text-primary-600 underline">Pobierz CV (ang.)</a>') : '' )
                        //     ->extraAttributes(['class' => 'py-2 mt-10'])
                        //     ->disableLabel(),

                    ]),


            // *******  obszar 2    ***********************************************
                Fieldset::make('')->columnSpan('full')
                    ->columns(2)
                    ->schema([
                        Textarea::make('experience')
                            ->default(null),

                        Textarea::make('notes')
                            ->default(null),

                        TextInput::make('status')
                            ->default(null),

                        TextInput::make('sent_to')
                            ->default(null),

                        TextInput::make('feedback')
                            ->default(null),

                        TextInput::make('interview')
                            ->default(null),
                ]),

            ])
        ;
    }
}
