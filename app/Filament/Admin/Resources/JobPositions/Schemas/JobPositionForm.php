<?php

namespace App\Filament\Admin\Resources\JobPositions\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class JobPositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('')
                    ->columns(1)
                    ->schema([
                        Radio::make('published')
                            ->label('Published')
                            ->boolean()
                            ->inline(true)
                            ->default(false),

                        TextInput::make('name')
                            ->label('Name')
                            ->required(),

                        // Editor (form-only) fields
                        Select::make('lang')
                            ->label('Language')
                            ->options(['en' => 'English', 'pl' => 'Polski'])
                            ->default('en')
                            ->live(),

                        Select::make('looking_for_candidates')
                            ->label('Heading phrase')
                            ->options([
                                'en' => 'We are looking for candidates on the position of',
                                'pl' => 'Poszukujemy kandydatów do pracy na stanowisku',
                            ])
                            ->default('en')
                            ->helperText('Displayed over the position name'),

                        TextInput::make('location')
                            ->label('Location line')
                            ->placeholder('Location: Bydgoszcz / Miejsce pracy: Bydgoszcz')
                            ->default('Location: Bydgoszcz'),

                        TextInput::make('job_description')
                            ->label('Job description heading')
                            ->default('')
                            ->placeholder('Job description / Opis stanowiska'),

                        Textarea::make('option1')
                            ->label('Optional paragraph 1')
                            ->default('')
                            ->hint('Shown above the first list'),

                        TextInput::make('key_responsibilities')
                            ->label('Key responsibilities heading')
                            ->placeholder('Key responsibilities'),

                        Textarea::make('resp_items_text')
                            ->label('Responsibilities (one per line)')
                            ->rows(5)
                            ->placeholder("Process and manage customer orders\nCommunicate with suppliers..."),

                        TextInput::make('option2_title')
                            ->label('Optional paragraph 2 title')
                            ->default('')
                            ->hint('Shown under the first list'),

                        Textarea::make('option2')
                            ->label('Optional paragraph 2')
                            ->default('')
                            ->hint('Shown under the first list'),

                        TextInput::make('our_requirements')
                            ->label('Our requirements heading')
                            ->placeholder('Our requirements'),

                        Textarea::make('req_items_text')
                            ->label('Requirements (one per line)')
                            ->rows(5),

                        // Select::make('option3')
                        //     ->label('Optional paragraph 3')
                        //     ->default('')
                        //     ->hint('Shown under the second list'),

                        TextInput::make('we_offer')
                            ->label('We offer heading')
                            ->placeholder('We offer'),

                        Textarea::make('offer_items_text')
                            ->label('We offer items (one per line)')
                            ->rows(5),

                        // Stored technical fields
                        TextInput::make('filename')
                            ->label('Filename (includes .pdf)')
                            ->helperText('Auto-filled from Name after saving; you may override.')
                            ->disabled(),
                    ])
            ]);
    }
}
