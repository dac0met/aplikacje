<?php

namespace App\Filament\Admin\Resources\Applicants\Schemas;

use Filament\Schemas\Schema;
use App\Models\ConsentSource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;

class ApplicantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('consent_source_id')               // przechowujemy ID rekordu
                    ->label('Źródło zgody')
                    ->relationship('consentSource', 'label')   // relacja w modelu (patrz niżej), automatycznie pobiera label
                    ->searchable()                              // możliwość wyszukiwania
                    ->placeholder('Wybierz lub wpisz nową wartość')
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

                TextInput::make('submission_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('job_position_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('submitted_date')
                    ,
                TextInput::make('user_ip')
                    ->default(null),
                TextInput::make('name')
                    ->required(),
                TextInput::make('surname')
                    ->required(),
                TextInput::make('yob')
                    ->numeric()
                    ->default(null),
                TextInput::make('city')
                    ->default(null),
                TextInput::make('phone')
                    ->tel()
                    ->numeric()
                    ->default(null),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null),
                
                Select::make('job_position')
                    // ->multiple() // !!! 
                    ->options([
                        'tailwind' => 'Tailwind CSS',
                        'alpine' => 'Alpine.js',
                        'laravel' => 'Laravel',
                        'livewire' => 'Laravel Livewire',
                    ])
                    ->default(null),
                TextInput::make('education')
                    ->default(null),
                Textarea::make('university')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('field_of_study')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('english')
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
                    ->default(null),

                TextInput::make('another_lang')
                    ->default(null),

                TextInput::make('another_level')
                    ->default(null),

                Textarea::make('experience')
                    ->default(null)
                    ->columnSpanFull(),

                Toggle::make('shift_work')
                    ->onColor('success')
                    ->offColor('danger')
                    ->required(),

                Toggle::make('consent')
                    ->onColor('success')
                    ->offColor('danger')
                    ->required(),


                TextInput::make('salary')
                    ->numeric()
                    ->default(null),
                TextInput::make('cv_pl')
                    ->default(null),
                TextInput::make('cv_gb')
                    ->default(null),
                TextInput::make('status')
                    ->default(null),
                
                TextInput::make('info')
                    ->default(null),
                TextInput::make('sent_to')
                    ->default(null),
                TextInput::make('interview')
                    ->default(null),
                TextInput::make('feedback')
                    ->default(null),
                TextInput::make('gender')
                    ->default(null),
                TextInput::make('gross')
                    ->default(null),
                
                TextInput::make('notes')
                    ->default(null),
            ]);
    }
}
