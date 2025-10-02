<?php

namespace App\Filament\Admin\Resources\Applicants\Schemas;

use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use App\Models\ConsentSource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
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

                        TextInput::make('name')
                            ->columnspan(4)
                            ->required(),

                        TextInput::make('surname')
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

                        TextInput::make('yob')
                            ->columnspan(1)
                            ->mask('9999')
                            ->default(null),

                        Select::make('consent_source_id')               // przechowujemy ID rekordu
                            ->label('Source of consent')
                            ->columnspan(4)
                            ->relationship('consentSource', 'label')   // relacja w modelu (patrz niżej), automatycznie pobiera label
                            // ->searchable()                              // możliwość wyszukiwania
                            ->placeholder('Select or enter a new value')
                            ->createOptionForm([                        // Formularz, który pojawi się po wpisaniu nowego tekstu
                                TextInput::make('key')
                                    ->required()
                                    ->unique(table: ConsentSource::class, column: 'key')
                                    ->maxLength(100),

                                TextInput::make('label')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->createOptionUsing(fn (array $data) =>                         // Zapisujemy nową opcję i zwracamy jej ID, żeby Select ją od razu wybrał
                                ConsentSource::create($data)->getKey())
                            ->required(),


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


                        // TextInput::configureUsing(function (TextInput $component): void {
                        //     $component->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/');
                        // }),

                        Select::make('job_position_id')
                            ->label('Position')
                            ->columnspan(6)
                            ->relationship('jobPosition','name')
                            ->default(null),

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
                                'a1' => 'A1',
                                'a2' => 'A2',
                                'b1' => 'B1',
                                'b2' => 'B2',
                                'c1' => 'C1',
                                'c2' => 'C2',
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
                            // ->inline()
                            ->options([
                                'current' => 'Current',
                                'future' => 'Current and Future',
                            ]),
                ]),

            // *******  obszar plików CV  ***********************************************
                Fieldset::make('')->columnSpan('full')
                    ->columns(2)
                    ->schema([

                //  PL – polska wersja CV
                // ------------------------------
                        FileUpload::make('cv_pl')
                            ->columns(1)
                            ->multiple(false)
                            ->storeFileNamesIn('orig_filename_pl')
                            // ->preserveFilenames(true)
                            // ->getUploadedFileNameForStorageUsing(function ($file) {
                            //     // Generujemy unikalną nazwę pliku, np. dodając timestamp
                            //     $timestamp = now()->timestamp;
                            //     $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                            //     $extension = $file->getClientOriginalExtension();
                            //     return $timestamp . '_' . $originalName . '.' . $extension;
                            // })
                            ->downloadable()
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.oasis.opendocument.text',
                            ])
                            ->disk('local')
                            ->directory('pl')
                            ->visibility('private'),

                //   GB – angielska wersja CV
                // ----------------------------------
                        FileUpload::make('cv_gb')
                            ->columns(1)
                            ->multiple(false)
                            ->storeFileNamesIn('orig_filename_gb')
                            // ->preserveFilenames(true)
                            // ->previewable(true)
                            // ->getUploadedFileNameForStorageUsing(function ($file) {
                            //     // Generujemy unikalną nazwę pliku, np. dodając timestamp
                            //     $timestamp = now()->timestamp;
                            //     $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                            //     $extension = $file->getClientOriginalExtension();
                            //     return $timestamp . '_' . $originalName . '.' . $extension;
                            // })
                            ->downloadable()
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.oasis.opendocument.text',
                            ])
                            ->disk('local')
                            ->directory('gb')
                            ->visibility('private')
                    ]),


            // *******  obszar 2    ***********************************************
                Fieldset::make('')->columnSpan('full')
                    ->columns(2)
                    ->schema([
                        Textarea::make('experience')
                            ->default(null)
                            // ->columnSpanFull(),
                            // ->columnSpan(2)
                            ,

                        Textarea::make('notes')
                            ->default(null),
                    ]),


            // *******  obszar 3    ***********************************************
                Fieldset::make('')->columnSpan('full')
                    ->schema([
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
