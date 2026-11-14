<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required(),
                TextInput::make('project_tag'),
                FileUpload::make('image_path')
                    ->label('Foto')
                    ->image(),
                Textarea::make('caption')
                    ->columnSpanFull(),
                
            ]);
    }
}
