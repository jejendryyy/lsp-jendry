<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;


class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Kategori')
                    ->options(fn(): array => Category::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Produk')
                    ->live(onBlur:true)
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('price')
                    ->label('Harga')
                    ->required()
                    ->maxLength(120),
                TextInput::make('server_specs')
                    ->label('Spesifikasi hardware / kapasitas layanan')
                    ->required()
                    ->maxLength(180),
                Textarea::make('short_description')
                    ->label('Deskripsi Singkat')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                RichEditor::make('full_description')
                    ->label('Rincian spesifikasi')
                    ->columnSpanFull(),
                FileUpload::make('image_url')
                    ->label('Gambar layanan')
                    ->image()->disk('public')
                    ->required()
                    ->directory('products')
                    ->visibility('public')
                    ->maxSize(5120),
            ]);
    }
}
