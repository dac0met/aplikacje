<?php

namespace App\Filament\Manager\Resources\Applicants\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\URL;

class ApplicantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('')->columnSpan('full')
                    ->columns(12)
                    ->schema([
                        TextInput::make('id')
                            ->columnSpan(2),
                        DateTimePicker::make('submitted_date')
                            ->columnSpan(4),
                    ]),
                    Fieldset::make('')->columnSpan('full')
                    ->columns(12)
                    ->schema([
                        TextInput::make('firstname')
                            ->columnSpan(4)
                            ->label('First name'),
                        TextInput::make('lastname')
                            ->columnSpan(4)
                            ->label('Last name'),
                        TextInput::make('yob')
                            ->columnSpan(2)
                            ->label('Year of birth')
                            ->numeric()
                            ->default(null),
                        TextInput::make('city')
                            ->columnSpan(4)
                            ->label('City')
                            ->default(null),
                        TextInput::make('phone')
                            ->columnSpan(2)
                            ->label('Phone')
                            ->tel()
                            ->numeric()
                            ->default(null),
                        TextInput::make('email')
                            ->columnSpan(5)
                            ->label('Email address')
                            ->email()
                            ->default(null),
                        
                        Textarea::make('position')
                            ->columnSpan(5)
                            ->label('Selected positions')
                            ->readOnly(true)
                            ->rows(3)
                            ->placeholder('No selected positions !')
                            ->afterStateHydrated(function ($component, $state) {
                                $record = $component->getRecord();
                                if ($record && $record->jobPositions) {
                                    $component->state(
                                        $record->jobPositions->pluck('name')->join("\n ")
                                    );
                                } else {
                                    $component->state($state);
                                }
                            }),
                        TextInput::make('consent')
                            ->columnSpan(3)
                            ->label('Consent to recruitment')
                            ->default(null),
                        TextInput::make('education')
                            ->columnSpan(4)
                            ->label('Education')
                            ->default(null),
                        Textarea::make('university')
                            ->columnSpan(4)
                            ->label('University')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('field_of_study')
                            ->columnSpan(4)
                            ->label('Field of study')
                            ->default(null)
                            ->columnSpanFull(),
                        TextInput::make('english')
                            ->columnSpan(2)
                            ->label('English level')
                            ->default(null),
                        TextInput::make('english_rating')
                            ->columnSpan(2)
                            ->label('English rating')
                            ->default(null),
                        TextInput::make('another_lang')
                            ->columnSpan(2)
                            ->label('Another language')
                            ->default(null),
                        TextInput::make('another_level')
                            ->columnSpan(2)
                            ->label('Another language level')
                            ->default(null),
                        Textarea::make('experience')
                            ->columnSpan(4)
                            ->label('Experience')
                            ->default(null)
                            ->columnSpanFull(),
                        Radio::make('shift_work')
                            ->label('Shift work')
                            ->columnspan(3)
                            ->boolean()
                            ->inline(),
                            
                        TextInput::make('salary')
                            ->columnSpan(2)
                            ->label('Salary')
                            ->numeric()
                            ->default(null),
                        TextInput::make('gross')
                            ->columnSpan(2)
                            ->label('Gross')
                            ->default(null),

                        View::make('filament.forms.download-link')
                                    ->columnSpan(2)
                                    ->hidden(fn ($record) => !($record && $record->cv_pl))
                                    ->extraAttributes(['class' => 'py-2'])
                                    ->viewData(fn ($record) => [
                                        'url' => $record ? URL::temporarySignedRoute('applicants.download.cv_pl', now()->addMinutes(10), $record) : null,
                                        'label' => 'Pobierz CV (pl)',
                                    ]),

                        View::make('filament.forms.download-link')
                                    ->columnSpan(2)
                                    ->hidden(fn ($record) => !($record && $record->cv_gb))
                                    ->extraAttributes(['class' => 'py-2'])
                                    ->viewData(fn ($record) => [
                                        'url' => $record ? URL::temporarySignedRoute('applicants.download.cv_gb', now()->addMinutes(10), $record) : null,
                                        'label' => 'Pobierz CV (ang.)',
                                    ]),
                        TextInput::make('status')
                            ->columnSpan(4)
                            ->label('Status')
                            ->default(null),
                        TextInput::make('sent_to')
                            ->columnSpan(12)
                            ->label('Sent to')
                            ->default(null),
                        TextInput::make('info')
                            ->columnSpan(12)
                            ->label('Info')
                            ->default(null),
                        TextInput::make('interview')
                            ->columnSpan(12)
                            ->label('Interview')
                            ->default(null),
                        TextInput::make('feedback')
                            ->columnSpan(12)
                            ->label('Feedback')
                            ->default(null),

                        // TextInput::make('consent_source')
                        //     ->columnSpan(2)
                        //     ->label('Consent source')
                        //     ->default(null),
                        TextInput::make('notes')
                            ->columnSpan(12)
                            ->label('Notes')
                            ->default(null),
                    ])
            ]);
    }
}
