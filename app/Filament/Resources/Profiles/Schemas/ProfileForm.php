<?php

namespace App\Filament\Resources\Profiles\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('deskripsi')
                    ->label('Deskripsi Singkat')
                    ->required()
                    ->maxLength(255)
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('visi')
                    ->label('Visi')
                    ->required()
                    ->maxLength(255)
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('misi')
                    ->label('Misi')
                    ->required()
                    ->maxLength(255)
                    ->rows(5)
                    ->columnSpanFull(),
            ]);
    }
}
