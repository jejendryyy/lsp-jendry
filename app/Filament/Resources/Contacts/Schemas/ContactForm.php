<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sender_name')
                    ->disabled()
                    ->required(),
                TextInput::make('sender_email')
                    ->email()
                    ->disabled()
                    ->required(),
                TextInput::make('sender_phone')
                    ->disabled()
                    ->tel(),
                Textarea::make('message')
                    ->required()
                    ->disabled()
                    ->columnSpanFull(),
                DateTimePicker::make('read_at'),
            ]);
    }
}
