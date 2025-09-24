<?php

namespace App\Filament\Manager\Resources\Applicants\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ApplicantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('submission_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('job_position_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('submitted_date'),
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
                TextInput::make('consent')
                    ->default(null),
                TextInput::make('job_position')
                    ->default(null),
                TextInput::make('education')
                    ->default(null),
                Textarea::make('university')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('field_of_study')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('english')
                    ->default(null),
                TextInput::make('another_lang')
                    ->default(null),
                TextInput::make('another_level')
                    ->default(null),
                Textarea::make('experience')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('shift_work')
                    ->required()
                    ->default(''),
                TextInput::make('salary')
                    ->numeric()
                    ->default(null),
                TextInput::make('cv_pl')
                    ->default(null),
                TextInput::make('cv_gb')
                    ->default(null),
                TextInput::make('status')
                    ->default(null),
                TextInput::make('english_rating')
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
                TextInput::make('consent_source')
                    ->default(null),
                TextInput::make('notes')
                    ->default(null),
            ]);
    }
}
